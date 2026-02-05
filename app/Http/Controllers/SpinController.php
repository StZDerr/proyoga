<?php

namespace App\Http\Controllers;

use App\Models\Prize;
use App\Services\WheelService;
use Illuminate\Http\Request;
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
            'phone' => 'required|string|max:32',
            'agree' => 'accepted',
        ]);

        try {
            $spin = $wheel->spinByPhone($validated['phone'], ['ip' => $request->ip()]);
            $prize = $spin->prize;

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
