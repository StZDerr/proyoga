<?php

namespace App\Http\Controllers;

use App\Models\SubSubCategory;
use App\Models\SubSubCategoryFaq;
use Illuminate\Http\Request;

class SubSubCategoryFaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $subSubCategories = SubSubCategory::orderBy('title')->get();

        $selectedSubSubCategoryId = $request->input('sub_sub_category_id');

        $faqs = SubSubCategoryFaq::with('subSubCategory', 'author')
            ->when($selectedSubSubCategoryId, function ($query, $id) {
                $query->where('sub_sub_category_id', $id);
            })
            ->orderBy('sub_sub_category_id')
            ->orderBy('sort_order')
            ->paginate(20);

        return view('admin.sub-sub-category-faqs.index', compact('faqs', 'subSubCategories', 'selectedSubSubCategoryId'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function update(Request $request, SubSubCategoryFaq $subSubCategoryFaq)
    {
        $validated = $request->validate([
            'sub_sub_category_id' => 'required|exists:sub_sub_categories,id',
            'question' => 'required|string|max:1000',
            'answer' => 'nullable|string',
            'sort_order' => 'nullable|integer',
        ]);

        $subSubCategoryFaq->update($validated);

        return redirect()->back()->with('success', 'FAQ успешно обновлен');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, ?SubSubCategory $subSubCategory = null)
    {
        $data = $request->validate([
            'question' => 'required|string|max:1000',
            'answer' => 'nullable|string',
            'sort_order' => 'nullable|integer',
            'sub_sub_category_id' => 'nullable|exists:sub_sub_categories,id',
        ]);

        // determine parent
        if ($subSubCategory) {
            $parent = $subSubCategory;
        } elseif (! empty($data['sub_sub_category_id'])) {
            $parent = SubSubCategory::find($data['sub_sub_category_id']);
            if (! $parent) {
                return $this->respondError($request, 'Родительская под‑подкатегория не найдена.');
            }
        } else {
            return $this->respondError($request, 'Требуется идентификатор под‑подкатегории.');
        }

        $faq = $parent->faqs()->create([
            'question' => $data['question'],
            'answer' => $data['answer'] ?? null,
            'sort_order' => $data['sort_order'] ?? 0,
            'created_by' => auth()->id(),
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'faq' => $faq], 201);
        }

        return redirect()->back()->with('success', 'Вопрос добавлен');
    }

    /**
     * Display the specified resource.
     */
    public function show(SubSubCategoryFaq $subSubCategoryFaq)
    {
        return view('admin.sub-sub-category-faqs.show', ['faq' => $subSubCategoryFaq]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubSubCategoryFaq $subSubCategoryFaq)
    {
        return view('admin.sub-sub-category-faqs.edit', ['faq' => $subSubCategoryFaq]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubSubCategoryFaq $subSubCategoryFaq)
    {
        $subSubCategoryFaq->delete();

        return redirect()->back()->with('success', 'FAQ успешно удален');
    }
}
