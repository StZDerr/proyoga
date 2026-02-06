<div class="mb-3">
    <label for="name" class="form-label">Название</label>
    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $spin->name ?? '') }}"
        required>
</div>

<div class="mb-3">
    <label for="color" class="form-label">Цвет</label>
    <input type="color" name="color" id="color" class="form-control form-control-color"
        value="{{ old('color', $spin->color ?? '#ffffff') }}" required>
</div>

<div class="mb-3">
    <label for="chance" class="form-label">Шанс (%)</label>
    <input type="number" name="chance" id="chance" class="form-control" min="0" max="100"
        value="{{ old('chance', $spin->chance ?? 0) }}" required>
    <div class="form-text">Введите целое число от 0 до 100. Сумма шансов может быть не равна 100 — выбор будет
        относительным.</div>
</div>

<div class="mb-3">
    <label for="description" class="form-label">Описание</label>
    <textarea name="description" id="description" class="form-control" rows="3">{{ old('description', $spin->description ?? '') }}</textarea>
</div>

<div class="form-check mb-3">
    <input class="form-check-input" type="checkbox" value="1" id="is_active" name="is_active"
        {{ old('is_active', $spin->is_active ?? true) ? 'checked' : '' }}>
    <label class="form-check-label" for="is_active">Активен</label>
</div>

<div class="mb-3">
    <label for="order" class="form-label">Порядок (для сортировки)</label>
    <input type="number" name="order" id="order" class="form-control" min="0"
        value="{{ old('order', $spin->order ?? 0) }}">
</div>
