<?php

namespace App\Http\Controllers;

use App\Jobs\SendTestSubmissionEmail;
use App\Jobs\SendVKMessage;
use App\Models\TestAnswer;
use App\Models\TestQuestion;
use App\Models\TestSubmission;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class TestController extends Controller
{
    /**
     * Получить все вопросы теста для API
     */
    public function getQuestions(): JsonResponse
    {
        $questions = TestQuestion::active()
            ->ordered()
            ->with(['options' => function ($query) {
                $query->orderBy('order_position');
            }])
            ->get();

        return response()->json([
            'success' => true,
            'questions' => $questions,
        ]);
    }

    /**
     * Сохранить результаты теста
     */
    public function submitTest(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => ['required', 'string', 'max:20', 'regex:/^\+?[0-9\-\s\(\)]{7,20}$/'],
            'email' => 'nullable|email|max:255',
            'answers' => 'required|array|min:1',
            'answers.*.question_id' => 'required|integer|exists:test_questions,id',
            'answers.*.option_id' => 'required|integer|exists:test_options,id',
            'privacy_agreement' => 'required|accepted',
            'smart-token' => ['required', new \App\Rules\YandexCaptcha()],
        ], [
            'name.required' => 'Имя обязательно',
            'name.string' => 'Имя должно быть строкой',
            'name.max' => 'Имя не должно превышать 255 символов',

            'phone.required' => 'Телефон обязателен',
            'phone.string' => 'Телефон должен быть строкой',
            'phone.max' => 'Телефон не должен превышать 20 символов',
            'phone.regex' => 'Неверный формат телефона',

            'email.email' => 'Неверный формат email',
            'email.max' => 'Email не должен превышать 255 символов',

            'answers.required' => 'Ответы обязательны',
            'answers.array' => 'Ответы должны быть массивом',
            'answers.min' => 'Нужно отправить хотя бы один ответ',

            'answers.*.question_id.required' => 'ID вопроса обязателен',
            'answers.*.question_id.integer' => 'ID вопроса должен быть числом',
            'answers.*.question_id.exists' => 'Вопрос не найден',

            'answers.*.option_id.required' => 'ID варианта обязателен',
            'answers.*.option_id.integer' => 'ID варианта должен быть числом',
            'answers.*.option_id.exists' => 'Вариант не найден',

            'privacy_agreement.required' => 'Необходимо согласие с политикой конфиденциальности',
            'privacy_agreement.accepted' => 'Подтвердите согласие с политикой конфиденциальности',

            'smart-token.required' => 'Необходимо пройти проверку капчи',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $validated = $validator->validated();

        try {
            $submission = DB::transaction(function () use ($validated) {
                $submission = TestSubmission::create([
                    'name' => $validated['name'],
                    'phone' => $validated['phone'],
                    'email' => $validated['email'] ?? null,
                    'completed_at' => now(),
                ]);

                foreach ($validated['answers'] as $answer) {
                    TestAnswer::create([
                        'test_submission_id' => $submission->id,
                        'test_question_id' => $answer['question_id'],
                        'test_option_id' => $answer['option_id'],
                    ]);
                }

                return $submission->load(['answers.question', 'answers.option']);
            });

            $emailsString = env('CONTACT_EMAIL', env('ADMIN_EMAIL', 'it@sumnikoff.ru'));
            $adminEmails = array_filter(array_map('trim', explode(',', (string) $emailsString)));

            SendTestSubmissionEmail::dispatch($submission, $adminEmails);

            $vkMessage = $this->buildVkMessage($submission);
            SendVKMessage::dispatch($vkMessage, config('services.vk.user_id'));
            SendVKMessage::dispatch($vkMessage, null, config('services.vk.chat_id'));

            return response()->json([
                'success' => true,
                'message' => 'Тест успешно отправлен! Мы свяжемся с вами в ближайшее время.',
            ]);
        } catch (\Exception $e) {
            Log::error('Test submission failed', [
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Произошла ошибка при сохранении данных. Попробуйте еще раз.',
            ], 500);
        }
    }

    private function buildVkMessage(TestSubmission $submission): string
    {
        $lines = [];

        $lines[] = '🧘 Новый результат теста на гибкость';
        $lines[] = '';
        $lines[] = '👤 Имя: '.$submission->name;
        $lines[] = '📱 Телефон: '.$submission->phone;

        if (! empty($submission->email)) {
            $lines[] = '📧 Email: '.$submission->email;
        }

        $lines[] = '🕒 Отправлен: '.($submission->completed_at?->format('d.m.Y H:i') ?? now()->format('d.m.Y H:i'));

        if ($submission->answers->isNotEmpty()) {
            $lines[] = '';
            $lines[] = '📋 Ответы:';

            foreach ($submission->answers as $index => $answer) {
                $questionText = $answer->question->question ?? ('Вопрос '.$answer->test_question_id);
                $optionText = $answer->option->option_text ?? ('Вариант '.$answer->test_option_id);

                $lines[] = ($index + 1).'. '.$questionText.' — '.$optionText;
            }
        }

        return implode("\n", $lines);
    }
}
