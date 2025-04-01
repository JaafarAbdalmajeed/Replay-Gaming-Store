@extends('layouts.dashboard')

@section('title', 'Edit Product')

@section('breadcrumb')
@parent
<li class="breadcrumb-item">Products</li>
<li class="breadcrumb-item active">Edit Product</li>
@endsection

@section('content')

<form action="{{ route('products.update', $product->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('put')

    @include('dashboard.products._form', [
        'button_label' => 'Update'
    ])
</form>

@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tagify/4.9.7/tagify.css" />
@endpush
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/tagify/4.9.7/tagify.min.js"></script>
@endpush

