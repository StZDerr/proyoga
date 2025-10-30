<?php

namespace App\Http\Controllers;

use App\Models\TestAnswer;
use App\Models\TestQuestion;
use App\Models\TestSubmission;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'answers' => 'required|array',
            'answers.*.question_id' => 'required|exists:test_questions,id',
            'answers.*.option_id' => 'required|exists:test_options,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            DB::transaction(function () use ($request) {
                // Создаем запись о прохождении теста
                $submission = TestSubmission::create([
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'completed_at' => now(),
                ]);

                // Сохраняем ответы
                foreach ($request->answers as $answer) {
                    TestAnswer::create([
                        'test_submission_id' => $submission->id,
                        'test_question_id' => $answer['question_id'],
                        'test_option_id' => $answer['option_id'],
                    ]);
                }
            });

            return response()->json([
                'success' => true,
                'message' => 'Тест успешно отправлен! Мы свяжемся с вами в ближайшее время.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Произошла ошибка при сохранении данных. Попробуйте еще раз.',
            ], 500);
        }
    }
}
