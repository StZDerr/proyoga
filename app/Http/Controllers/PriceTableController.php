<?php

namespace App\Http\Controllers;

use App\Models\PriceCategory;
use App\Models\PriceTable;
use Illuminate\Http\Request;

class PriceTableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Список категорий для выпадающего фильтра
        $categoriesList = PriceCategory::orderBy('name')->get();

        // Базовый запрос
        $query = PriceTable::query();

        // Фильтр по категории (GET ?category_id=)
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Защищаем сортировку — разрешённые поля
        $allowedSorts = ['sort_order', 'id', 'title', 'category'];
        $sort = in_array($request->get('sort'), $allowedSorts) ? $request->get('sort') : 'sort_order';
        $dir = $request->get('dir') === 'desc' ? 'desc' : 'asc';

        // Если сортируем по имени категории — делаем join
        if ($sort === 'category') {
            $query = $query
                ->leftJoin('price_categories', 'price_tables.category_id', '=', 'price_categories.id')
                ->orderBy('price_categories.name', $dir)
                ->select('price_tables.*'); // чтобы получить модели PriceTable
        } else {
            $query = $query->orderBy($sort, $dir);
        }

        // Получаем записи и подгружаем связь category, чтобы избежать N+1
        $tables = $query->get()->load('category');

        // Передаём текущие параметры в view (чтобы сохранять их в ссылках/формах)
        return view('admin.price_tables.index', [
            'tables' => $tables,
            'categoriesList' => $categoriesList,
            'currentSort' => $sort,
            'currentDir' => $dir,
            'currentCategory' => $request->get('category_id'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = PriceCategory::all();

        return view('admin.price_tables.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|integer|exists:price_categories,id',
        ], [
            'title.required' => 'Название обязательно',
            'title.string' => 'Название должно быть строкой',
            'title.max' => 'Название не должно превышать 255 символов',

            'category_id.required' => 'Категория обязательна',
            'category_id.integer' => 'Неверный идентификатор категории',
            'category_id.exists' => 'Выбранная категория не найдена',
        ]);

        // Устанавливаем порядок в конец списка
        $max = PriceTable::max('sort_order') ?? 0;
        $validated['sort_order'] = $max + 1;

        PriceTable::create($validated);

        return redirect()->route('admin.price-tables.index')
            ->with('success', 'Таблица добавлена!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PriceTable $priceTable)
    {
        $categories = PriceCategory::all();

        return view('admin.price_tables.edit', compact('priceTable', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PriceTable $priceTable)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|integer|exists:price_categories,id',
        ], [
            'title.required' => 'Название обязательно',
            'title.string' => 'Название должно быть строкой',
            'title.max' => 'Название не должно превышать 255 символов',

            'category_id.required' => 'Категория обязательна',
            'category_id.integer' => 'Неверный идентификатор категории',
            'category_id.exists' => 'Выбранная категория не найдена',
        ]);

        $priceTable->update($validated);

        return redirect()->route('admin.price-tables.index')
            ->with('success', 'Таблица обновлена!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PriceTable $priceTable)
    {
        $priceTable->delete();

        return redirect()->route('admin.price-tables.index')
            ->with('success', 'Таблица удалена!');
    }

    /**
     * Move the price table up (swap with previous).
     */
    public function moveUp(PriceTable $priceTable)
    {
        if ($priceTable->moveUp()) {
            return back()->with('success', 'Прайс поднят выше.');
        }

        return back()->with('info', 'Прайс уже вверху.');
    }

    /**
     * Move the price table down (swap with next).
     */
    public function moveDown(PriceTable $priceTable)
    {
        if ($priceTable->moveDown()) {
            return back()->with('success', 'Прайс опущен ниже.');
        }

        return back()->with('info', 'Прайс уже внизу.');
    }
}
