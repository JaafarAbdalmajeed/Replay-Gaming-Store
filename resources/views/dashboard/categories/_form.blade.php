<div class="card p-4">
    @if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<div class="mb-3">
    <label for="name" class="form-label">Category Name</label>
    <input type="text" class="form-control @error('name') is-invalid  @enderror" id="name" name="name" value="{{ old('name', $category->name ?? '') }}" >
    @error('name')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

<div class="mb-3">
    <label for="parent_id" class="form-label">Parent Category</label>
    <select class="form-control" id="parent_id" name="parent_id">
        <option value="">Primary Category</option>
        @foreach ($categories as $cat)
            <option value="{{ $cat->id }}" {{ isset($category) && $category->parent_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label for="description" class="form-label">Description</label>
    <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $category->description ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label for="image" class="form-label fw-bold">Upload Image</label>

    <div class="input-group">
        <input type="file" class="form-control d-none" id="image" name="image" accept="image/*" onchange="previewImage(event)">
        <label class="btn btn-primary" for="image">Choose Image</label>
    </div>

    @if(isset($category) && $category->image)
        <div class="mt-2">
            <img id="preview" src="{{ asset('storage/' . $category->image) }}" alt="Image Category" class="img-thumbnail" width="120">
        </div>
    @else
        <div class="mt-2">
            <img id="preview" src="" alt="" class="img-thumbnail d-none" width="120">
        </div>
    @endif
</div>

<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('preview');
            output.src = reader.result;
            output.classList.remove('d-none');
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>

<div class="mb-3">
    <label class="form-label">Status</label>
    <div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="status" id="active" value="active" {{ old('status', $category->status ?? 'active') == 'active' ? 'checked' : '' }}>
            <label class="form-check-label" for="active">Active</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="status" id="inactive" value="inactive" {{ old('status', $category->status ?? '') == 'inactive' ? 'checked' : '' }}>
            <label class="form-check-label" for="inactive">Inactive</label>
        </div>
    </div>
</div>

<button type="submit" class="btn btn-success">{{ isset($category) ? 'Update' : 'Create' }}</button>
