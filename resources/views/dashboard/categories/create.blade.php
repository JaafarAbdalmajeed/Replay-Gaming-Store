@extends('layouts.dashboard')

@section('title', 'New Categories')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">New Category</li>
@endsection

@section('content')

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

        <form action="{{ route('categories.store') }}" method="POST">
            @csrf
            @include('dashboard.categories._form')
        </form>
    </div>

@endsection
