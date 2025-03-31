@extends('layouts.dashboard')

@section('title', 'Products')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Products</li>
@endsection

@push('styles')
<style>
    .product-description {
        font-size: 14px;
        line-height: 1.6;
        color: #555;
        word-wrap: break-word;
    }
</style>

@endpush

@section('content')

    <div class="mb-3">
        <a href="{{ route('products.create') }}" class="btn btn-primary mr-3">
            <i class="fas fa-plus"></i> New Category
        </a>
                {{-- <a href="{{ route('products.trash') }}" class="btn btn-danger">
            <i class="fas fa-trash"></i> Trash
        </a> --}}
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
    <button type="submit" class="btn btn-primary btn-lg ml-2">
        <i class="fas fa-search"></i> Search
    </button>
</form>

    <table class="table table-bordered table-striped mt-3">
        <thead class="table-primary">
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Name</th>
                <th>Description</th>
                <th>Category</th>
                <th>Store</th>
                <th>Status</th>
                <th>Created At</th>
                <th colspan="2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>
                    @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="Category Image" width="100">
                    @else
                                                    <span class="text-muted">No Image</span>
                    @endif
                </td>
                <td>{{ $product->name }}</td>

                    <td>
                        @if(strlen($product->description) > 50)
                            <div id="description-{{ $product->id }}">
                                <span id="short-description-{{ $product->id }}">
                                    {{ \Str::limit($product->description, 100) }}
                                </span>
                                <span id="full-description-{{ $product->id }}" style="display: none;">
                                    {{ $product->description }}
                                </span>
                                <button onclick="toggleDescription({{ $product->id }})" class="btn btn-link">
                                    <span id="toggle-text-{{ $product->id }}">show more</span>
                                </button>
                            </div>
                        @else
                            <span>{{ $product->description }}</span>
                        @endif
                    </td>

                <td>{{ $product->category->name }}</td>
                <td>{{ $product->store->name }}</td>
                <td>
                    @if($product->status == 'active')
                        <span class="badge bg-success">Active</span>
                    @else
                        <span class="badge bg-danger">Inactive</span>
                    @endif
                </td>
                <td>{{ $product->created_at->format('d-m-Y H:i') }}</td>
                <td colspan="2">
                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="text-center">No Products Found</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{ $products->withQueryString()->links() }}

@endsection


@push('scripts')
<script>
    function toggleDescription(productId) {
        var shortDescription = document.getElementById('short-description-' + productId);
        var fullDescription = document.getElementById('full-description-' + productId);
        var toggleText = document.getElementById('toggle-text-' + productId);

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
