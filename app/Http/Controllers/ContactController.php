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
            'name.required' => 'Поле "Имя" обязательно для заполнения',
            'phone.required' => 'Поле "Телефон" обязательно для заполнения',
            'email.email' => 'Некорректный формат email',
            'privacy_agreement.required' => 'Необходимо согласие с политикой конфиденциальности',
            'privacy_agreement.accepted' => 'Необходимо согласие с политикой конфиденциальности',
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
