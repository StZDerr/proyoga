<?php

namespace App\Http\Controllers;

use App\Jobs\SendSpinEmail;
use App\Jobs\SendVKMessage;
use App\Models\Prize;
use App\Services\WheelService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class SpinController extends Controller
{
    public function prizes()
    {
        $prizes = Prize::where('is_active', true)->orderBy('order')->get(['id', 'name', 'color', 'chance', 'description']);
        return response()->json($prizes);
    }

    public function spin(Request $request, WheelService $wheel)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:80', 'regex:/^[\p{L}\s-]+$/u'],
            'phone' => 'required|string|max:32',
            'agree' => 'accepted',
        ]);

        try {
            $spin = $wheel->spinByPhone($validated['phone'], $validated['name'], ['ip' => $request->ip()]);
            $prize = $spin->prize;

            $data = [
                'name' => $validated['name'],
                'phone' => $validated['phone'],
                'prize_name' => $prize?->name ?? 'Не указан',
                'prize_description' => $prize?->description,
                'page_url' => $request->input('page_url', $request->headers->get('referer', 'Не указана')),
                'page_title' => $request->input('page_title', 'Не указан'),
            ];

            $emailsString = env('CONTACT_EMAIL', env('ADMIN_EMAIL', 'it@sumnikoff.ru'));
            $adminEmails = array_filter(array_map('trim', explode(',', $emailsString)));

            try {
                SendSpinEmail::dispatch($data, $adminEmails);

                $vkMessage = "🎯 Новое вращение колеса!\n\n";
                $vkMessage .= "👤 Имя: {$data['name']}\n";
                $vkMessage .= "📱 Телефон: {$data['phone']}\n";
                $vkMessage .= "🏆 Приз: {$data['prize_name']}\n";
                if (!empty($data['prize_description'])) {
                    $vkMessage .= "📝 Описание: {$data['prize_description']}\n";
                }
                $vkMessage .= "\n📄 Страница: {$data['page_title']}\n";
                $vkMessage .= "🔗 {$data['page_url']}";

                SendVKMessage::dispatch($vkMessage, config('services.vk.user_id'));
                SendVKMessage::dispatch($vkMessage, null, config('services.vk.chat_id'));
            } catch (\Throwable $e) {
                Log::warning('Spin notifications failed', [
                    'message' => $e->getMessage(),
                ]);
            }

            return response()->json([
                'success' => true,
                'prize' => $prize ? [
                    'id' => $prize->id,
                    'name' => $prize->name,
                    'color' => $prize->color,
                    'description' => $prize->description,
                ] : null,
            ]);
        } catch (ValidationException $e) {
            return response()->json(['success' => false, 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Server error'], 500);
        }
    }
}
