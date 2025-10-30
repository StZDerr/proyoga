<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TestQuestion;
use App\Models\TestOption;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Вопрос 1
        $question1 = TestQuestion::create([
            'question' => 'Вы когда-нибудь занимались йогой?',
            'order_position' => 1,
            'is_active' => true
        ]);

        TestOption::create([
            'test_question_id' => $question1->id,
            'option_text' => 'Нет, только слышал(а) о ней',
            'order_position' => 1
        ]);

        TestOption::create([
            'test_question_id' => $question1->id,
            'option_text' => 'Пробовал(а) несколько раз',
            'order_position' => 2
        ]);

        TestOption::create([
            'test_question_id' => $question1->id,
            'option_text' => 'Да, есть опыт регулярных занятий',
            'order_position' => 3
        ]);

        // Вопрос 2
        $question2 = TestQuestion::create([
            'question' => 'Как вы оцениваете вашу физическую подготовку?',
            'order_position' => 2,
            'is_active' => true
        ]);

        TestOption::create([
            'test_question_id' => $question2->id,
            'option_text' => 'Низкая - мало двигаюсь',
            'order_position' => 1
        ]);

        TestOption::create([
            'test_question_id' => $question2->id,
            'option_text' => 'Средняя - иногда занимаюсь спортом',
            'order_position' => 2
        ]);

        TestOption::create([
            'test_question_id' => $question2->id,
            'option_text' => 'Хорошая - регулярно тренируюсь',
            'order_position' => 3
        ]);

        // Вопрос 3
        $question3 = TestQuestion::create([
            'question' => 'Насколько хорошо вы можете дотянуться до пальцев ног, не сгибая колени?',
            'order_position' => 3,
            'is_active' => true
        ]);

        TestOption::create([
            'test_question_id' => $question3->id,
            'option_text' => 'Едва дотягиваюсь до голеней',
            'order_position' => 1
        ]);

        TestOption::create([
            'test_question_id' => $question3->id,
            'option_text' => 'Могу коснуться лодыжек',
            'order_position' => 2
        ]);

        TestOption::create([
            'test_question_id' => $question3->id,
            'option_text' => 'Легко касаюсь пальцев ног',
            'order_position' => 3
        ]);

        TestOption::create([
            'test_question_id' => $question3->id,
            'option_text' => 'Могу положить ладони на пол',
            'order_position' => 4
        ]);

        // Вопрос 4
        $question4 = TestQuestion::create([
            'question' => 'Есть ли у вас какие-либо проблемы со здоровьем или травмы?',
            'order_position' => 4,
            'is_active' => true
        ]);

        TestOption::create([
            'test_question_id' => $question4->id,
            'option_text' => 'Нет, чувствую себя хорошо',
            'order_position' => 1
        ]);

        TestOption::create([
            'test_question_id' => $question4->id,
            'option_text' => 'Иногда болит спина/шея',
            'order_position' => 2
        ]);

        TestOption::create([
            'test_question_id' => $question4->id,
            'option_text' => 'Есть проблемы с суставами',
            'order_position' => 3
        ]);

        TestOption::create([
            'test_question_id' => $question4->id,
            'option_text' => 'Есть серьезные ограничения по здоровью',
            'order_position' => 4
        ]);

        // Вопрос 5
        $question5 = TestQuestion::create([
            'question' => 'Что вас больше всего привлекает в йоге?',
            'order_position' => 5,
            'is_active' => true
        ]);

        TestOption::create([
            'test_question_id' => $question5->id,
            'option_text' => 'Улучшение гибкости и физической формы',
            'order_position' => 1
        ]);

        TestOption::create([
            'test_question_id' => $question5->id,
            'option_text' => 'Снятие стресса и расслабление',
            'order_position' => 2
        ]);

        TestOption::create([
            'test_question_id' => $question5->id,
            'option_text' => 'Духовное развитие и медитация',
            'order_position' => 3
        ]);

        TestOption::create([
            'test_question_id' => $question5->id,
            'option_text' => 'Укрепление здоровья в целом',
            'order_position' => 4
        ]);
    }
}
