<?php

namespace App\Http\Controllers;

use App\Models\SubSubCategoryPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SubSubCategoryPhotoController extends Controller
{
    public function destroy(Request $request, SubSubCategoryPhoto $photo)
    {
        if ($photo->image && Storage::disk('public')->exists($photo->image)) {
            Storage::disk('public')->delete($photo->image);
        }

        $photo->delete();

        // If request is AJAX, return JSON so frontend can react cleanly
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Фотография удалена');
    }
}
