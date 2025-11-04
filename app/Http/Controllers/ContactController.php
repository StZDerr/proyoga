<?php

namespace App\Http\Controllers;

use App\Jobs\SendContactEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function sendContactForm(Request $request)
    {
        // Валидация данных
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'message' => 'nullable|string|max:1000',
            'service' => 'nullable|string|max:255',
            'privacy_agreement' => 'required|accepted',
        ], [
            'name.required' => 'Имя обязательно',
            'name.string' => 'Имя должно быть строкой',
            'name.max' => 'Имя не должно превышать 255 символов',

            'phone.required' => 'Телефон обязателен',
            'phone.string' => 'Телефон должен быть строкой',
            'phone.max' => 'Телефон не должен превышать 20 символов',

            'email.email' => 'Неверный формат e‑mail',
            'email.max' => 'E‑mail не должен превышать 255 символов',

            'message.string' => 'Сообщение должно быть строкой',
            'message.max' => 'Сообщение не должно превышать 1000 символов',

            'service.string' => 'Услуга должна быть строкой',
            'service.max' => 'Название услуги не должно превышать 255 символов',

            'privacy_agreement.required' => 'Необходимо согласие с политикой конфиденциальности',
            'privacy_agreement.accepted' => 'Вы должны принять политику конфиденциальности',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            // Подготовка данных для письма
            $data = [
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'message' => $request->message,
                'service' => $request->service ?: 'Запись на занятие',
            ];

            // Получаем email администратора
            $adminEmail = env('CONTACT_EMAIL', env('ADMIN_EMAIL', 'admin@proyoga.ru'));

            // Ставим отправку письма в очередь
            SendContactEmail::dispatch($data, $adminEmail);

            // Сразу возвращаем успешный ответ пользователю
            return response()->json([
                'success' => true,
                'message' => 'Ваша заявка успешно принята! Мы свяжемся с вами в ближайшее время.',
            ]);

        } catch (\Exception $e) {
            \Log::error('Failed to queue email job: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Произошла ошибка при отправке заявки. Попробуйте позже или свяжитесь с нами по телефону.',
            ], 500);
        }
    }
}
