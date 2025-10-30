<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TestOption;
use App\Models\TestQuestion;
use App\Models\TestSubmission;
use Illuminate\Http\Request;

class TestAdminController extends Controller
{
    /**
     * Показать список заполненных тестов
     */
    public function submissions()
    {
        $submissions = TestSubmission::with('answers.question', 'answers.option')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.test-submissions.index', compact('submissions'));
    }

    /**
     * Показать детали конкретной заявки
     */
    public function showSubmission($id)
    {
        $submission = TestSubmission::with(['answers.question', 'answers.option'])
            ->findOrFail($id);

        return view('admin.test-submissions.show', compact('submission'));
    }

    /**
     * Отметить посещение бесплатного занятия
     */
    public function markVisited(Request $request, $id)
    {
        $submission = TestSubmission::findOrFail($id);
        $submission->update([
            'visited_free_class' => $request->has('visited'),
        ]);

        return redirect()->back()->with('success', 'Статус посещения обновлен');
    }

    /**
     * Управление вопросами теста
     */
    public function questions()
    {
        $questions = TestQuestion::with('options')->ordered()->get();

        return view('admin.test-questions.index', compact('questions'));
    }

    /**
     * Создать новый вопрос
     */
    public function createQuestion()
    {
        return view('admin.test-questions.create');
    }

    /**
     * Сохранить новый вопрос
     */
    public function storeQuestion(Request $request)
    {
        $request->validate([
            'question' => 'required|string',
            'options' => 'required|array|min:2',
            'options.*' => 'required|string',
        ]);

        $question = TestQuestion::create([
            'question' => $request->question,
            'order_position' => TestQuestion::max('order_position') + 1,
            'is_active' => true,
        ]);

        foreach ($request->options as $index => $optionText) {
            TestOption::create([
                'test_question_id' => $question->id,
                'option_text' => $optionText,
                'order_position' => $index + 1,
            ]);
        }

        return redirect()->route('admin.test.questions')->with('success', 'Вопрос создан успешно');
    }

    /**
     * Редактировать вопрос
     */
    public function editQuestion($id)
    {
        $question = TestQuestion::with('options')->findOrFail($id);

        return view('admin.test-questions.edit', compact('question'));
    }

    /**
     * Обновить вопрос
     */
    public function updateQuestion(Request $request, $id)
    {
        $request->validate([
            'question' => 'required|string',
            'options' => 'required|array|min:2',
            'options.*' => 'required|string',
        ]);

        $question = TestQuestion::findOrFail($id);
        $question->update([
            'question' => $request->question,
            'is_active' => $request->has('is_active'),
        ]);

        // Удаляем старые варианты ответов
        $question->options()->delete();

        // Добавляем новые варианты ответов
        foreach ($request->options as $index => $optionText) {
            TestOption::create([
                'test_question_id' => $question->id,
                'option_text' => $optionText,
                'order_position' => $index + 1,
            ]);
        }

        return redirect()->route('admin.test.questions')->with('success', 'Вопрос обновлен успешно');
    }

    /**
     * Удалить вопрос
     */
    public function deleteQuestion($id)
    {
        $question = TestQuestion::findOrFail($id);
        $question->delete();

        return redirect()->route('admin.test.questions')->with('success', 'Вопрос удален успешно');
    }
}
