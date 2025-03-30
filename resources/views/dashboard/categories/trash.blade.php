@extends('layouts.dashboard')

@section('title', 'Trash Categories')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Trash Categories</li>
@endsection

@push('styles')
<style>
    .category-description {
        font-size: 14px;
        line-height: 1.6;
        color: #555;
        word-wrap: break-word;
    }
</style>

@endpush

@section('content')

    <div class="mb-3">
        <a href="{{ route('categories.index') }}" class="btn btn-primary">Back</a>
    </div>

<x-alert></x-alert>

<form action="{{ URL::current() }}" method="GET" class="d-flex justify-content-between align-items-center mb-4 p-3 border rounded shadow-sm">
    <!-- Name Input -->
    <div class="form-group flex-grow-1 mr-2">
        <label for="name" class="sr-only">Search by name</label>
        <x-form.input
        id="name"
        name="name"
        aria-label="Search by name"
        placeholder="Enter name"
        class="form-control form-control-lg"
        label="Name"
        type="text"
        :value="request('name')"
    />
        </div>

    <!-- Status Dropdown -->
    <div class="form-group ml-2">
        <label for="status" class="sr-only">Select status</label>
        <select
            id="status"
            name="status"
            class="form-control form-control-lg"
            aria-label="Select status"
        >
            <option value="">All Statuses</option>
            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
            <option value="archive" {{ request('status') == 'archive' ? 'selected' : '' }}>Archived</option>
        </select>
    </div>

    <!-- Submit Button -->
    <button type="submit" class="btn btn-primary btn-lg ml-2">Search</button>
</form>

    <table class="table table-bordered table-striped mt-3">
        <thead class="table-primary">
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Name</th>
                <th>Description</th>
                <th>Status</th>
                <th>Deleted At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($categories as $category)
            <tr>
                <td>{{ $category->id }}</td>
                <td>
                    @if($category->image)
                    <img src="{{ asset('storage/' . $category->image) }}" alt="Category Image" width="100">
                    @else
                                                    <span class="text-muted">No Image</span>
                    @endif
                </td>
                <td>{{ $category->name }}</td>

                    <td>
                        @if(strlen($category->description) > 50)
                            <div id="description-{{ $category->id }}">
                                <span id="short-description-{{ $category->id }}">
                                    {{ \Str::limit($category->description, 100) }}
                                </span>
                                <span id="full-description-{{ $category->id }}" style="display: none;">
                                    {{ $category->description }}
                                </span>
                                <button onclick="toggleDescription({{ $category->id }})" class="btn btn-link">
                                    <span id="toggle-text-{{ $category->id }}">show more</span>
                                </button>
                            </div>
                        @else
                            <span>{{ $category->description }}</span>
                        @endif
                    </td>

                <td>
                    @if($category->status == 'active')
                        <span class="badge bg-success">Active</span>
                    @else
                        <span class="badge bg-danger">Inactive</span>
                    @endif
                </td>
                <td>{{ $category->deleted_at->format('d-m-Y H:i') }}</td>
                <td colspan="2">
                    <form action="{{ route('categories.restore', $category->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-info btn-sm">
                            <i class="bi bi-trash"></i> Restore
                        </button>
                    </form>
                    <form action="{{ route('categories.force-delete', $category->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="bi bi-trash"></i> Force Delete
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center">No Categories Found</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{ $categories->withQueryString()->links() }}

@endsection


@push('scripts')
<script>
    function toggleDescription(categoryId) {
        var shortDescription = document.getElementById('short-description-' + categoryId);
        var fullDescription = document.getElementById('full-description-' + categoryId);
        var toggleText = document.getElementById('toggle-text-' + categoryId);

        if (fullDescription.style.display === "none") {
            fullDescription.style.display = "inline";
            shortDescription.style.display = "none";
            toggleText.textContent = "show less";
        } else {
            fullDescription.style.display = "none";
            shortDescription.style.display = "inline";
            toggleText.textContent = "show more";
        }
    }
</script>
@endpush
