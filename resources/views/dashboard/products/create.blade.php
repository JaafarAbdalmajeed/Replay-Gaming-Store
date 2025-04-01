@extends('layouts.dashboard')

@section('title', 'Products')

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Products</li>
@endsection

@section('content')

<form action="{{ route('dashboard.products.store') }}" method="post" enctype="multipart/form-data">
    @csrf

    @include('dashboard.products._form')
</form>

@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tagify/4.9.7/tagify.css" />
@endpush
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/tagify/4.9.7/tagify.min.js"></script>
@endpush
