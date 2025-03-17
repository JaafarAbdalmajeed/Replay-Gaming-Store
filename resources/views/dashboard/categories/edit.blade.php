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
        @include('dashboard.categories._form')
    </form>
</div>
 @endsection
