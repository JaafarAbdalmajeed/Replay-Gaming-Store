@extends('layouts.dashboard')

@section('title', 'New Categories')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">New Category</li>
@endsection

@section('content')


<form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
 @csrf
            @include('dashboard.categories._form')
        </form>
    </div>

@endsection
