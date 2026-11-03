<div class="mb-3">
    <label for="title" class="form-label">Titre <span class="text-danger">*</span></label>
    <input type="text" name="title" id="title"
           class="form-control @error('title') is-invalid @enderror"
           value="{{ old('title', $task->title) }}">
    @error('title')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="responsible" class="form-label">Responsable <span class="text-danger">*</span></label>
    <input type="text" name="responsible" id="responsible"
           class="form-control @error('responsible') is-invalid @enderror"
           value="{{ old('responsible', $task->responsible) }}">
    @error('responsible')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="due_date" class="form-label">Date d'échéance <span class="text-danger">*</span></label>
    <input type="date" name="due_date" id="due_date"
           class="form-control @error('due_date') is-invalid @enderror"
           value="{{ old('due_date', optional($task->due_date)->format('Y-m-d')) }}">
    @error('due_date')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="status" class="form-label">Statut <span class="text-danger">*</span></label>
    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
        @foreach (\App\Models\Task::STATUSES as $code => $label)
            <option value="{{ $code }}" @selected(old('status', $task->status) === $code)>
                {{ $label }}
            </option>
        @endforeach
    </select>
    @error('status')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-4">
    <label for="description" class="form-label">Description (facultative)</label>
    <textarea name="description" id="description" rows="4"
              class="form-control @error('description') is-invalid @enderror">{{ old('description', $task->description) }}</textarea>
    @error('description')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<button type="submit" class="btn btn-primary">{{ $submitButtonText ?? 'Enregistrer' }}</button>
<a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary">Annuler</a>
