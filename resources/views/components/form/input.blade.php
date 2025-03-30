<div class="mb-3">
    <label for="{{ $id }}" class="form-label">{{ $label }}</label>
    <input
        type="{{ $type }}"
        class="form-control @error($name) is-invalid @enderror"
        id="{{ $id }}"
        name="{{ $name }}"
        value="{{ old($name, $value) }}"
        placeholder="{{ $placeholder ?? 'Enter ' . $label }}"
        aria-label="{{ $label }}"
    >
    @error($name)
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
