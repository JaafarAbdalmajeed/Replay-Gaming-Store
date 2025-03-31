@extends('layouts.dashboard')

@section('title', 'Edit Categories')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Category</li>
    <li class="breadcrumb-item active">{{ $category->name }}</li>
@endsection

@section('content')

<table class="table table-bordered table-striped mt-3">
    <thead class="table-primary">
        <tr>
            <th>Image</th>
            <th>Name</th>
            <th>Store</th>
            <th>Status</th>
            <th>Created At</th>
        </tr>
    </thead>
    <tbody>
        @php
            $products = $category->products()->with('store')->latest()->paginate(5)
        @endphp
        @forelse ($products as $product)
        <tr>
            <td>
                @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="Category Image" width="100">
                @else
                                                <span class="text-muted">No Image</span>
                @endif
            </td>
            <td>{{ $product->name }}</td>



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

{{ $products->links() }}

@endsection
