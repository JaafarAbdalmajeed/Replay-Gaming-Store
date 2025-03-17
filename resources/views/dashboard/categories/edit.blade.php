@extends('layouts.dashboard')

@section('title', 'Edit Categories')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Edit Category</li>
@endsection

@section('content')
<div class="card p-4">
    <form action="{{ isset($category) ? route('categories.update', $category->id) : route('categories.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($category))
            @method('PUT')
        @endif

        <div class="mb-3">
            <label for="name" class="form-label">Category Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $category->name ?? '') }}" required>
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
            <label for="image" class="form-label">Image</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*">
            @if(isset($category) && $category->image)
                <img src="{{ asset('storage/' . $category->image) }}" alt="Category Image" class="img-thumbnail mt-2" width="100">
            @endif
        </div>

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
    </form>
</div>
 @endsection
