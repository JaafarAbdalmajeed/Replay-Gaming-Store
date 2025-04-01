@extends('layouts.dashboard')

@section('title', 'Edit Profile')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Edit Profile</li>
@endsection

@section('content')
<div class="card p-4">
    <form action="{{ route('profile.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <!-- First Name -->
        <div class="mb-3">
            <label for="first_name" class="form-label">First Name</label>
            <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $user->profile->first_name ?? '') }}" required>
            @error('first_name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Last Name -->
        <div class="mb-3">
            <label for="last_name" class="form-label">Last Name</label>
            <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $user->profile->last_name ?? '') }}" required>
            @error('last_name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Birthday -->
        <div class="mb-3">
            <label for="birthday" class="form-label">Birthday</label>
            <input type="date" name="birthday" class="form-control" value="{{ old('birthday', $user->profile->birthday ?? '') }}">
            @error('birthday')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Gender -->
        <div class="mb-3">
            <label for="gender" class="form-label">Gender</label>
            <select name="gender" class="form-control">
                <option value="male" {{ old('gender', $user->profile->gender) == 'male' ? 'selected' : '' }}>Male</option>
                <option value="female" {{ old('gender', $user->profile->gender) == 'female' ? 'selected' : '' }}>Female</option>
                <option value="other" {{ old('gender', $user->profile->gender) == 'other' ? 'selected' : '' }}>Other</option>
            </select>
            @error('gender')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Street Address -->
        <div class="mb-3">
            <label for="street_address" class="form-label">Street Address</label>
            <input type="text" name="street_address" class="form-control" value="{{ old('street_address', $user->profile->street_address ?? '') }}">
            @error('street_address')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- City -->
        <div class="mb-3">
            <label for="city" class="form-label">City</label>
            <input type="text" name="city" class="form-control" value="{{ old('city', $user->profile->city ?? '') }}">
            @error('city')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- State -->
        <div class="mb-3">
            <label for="state" class="form-label">State</label>
            <input type="text" name="state" class="form-control" value="{{ old('state', $user->profile->state ?? '') }}">
            @error('state')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Postal Code -->
        <div class="mb-3">
            <label for="postal_code" class="form-label">Postal Code</label>
            <input type="text" name="postal_code" class="form-control" value="{{ old('postal_code', $user->profile->postal_code ?? '') }}">
            @error('postal_code')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Country -->
        <div class="mb-3">
            <label for="country" class="form-label">Country</label>
            <select name="country" class="form-control">
                <option value="">Select Country</option>
                @foreach($countries as $code => $name)
                    <option value="{{ $code }}" {{ old('country', auth()->user()->profile->country ?? '') == $code ? 'selected' : '' }}>
                        {{ $name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Locale Dropdown -->
        <div class="mb-3">
            <label for="locale" class="form-label">Locale (Language/Region)</label>
            <select name="locale" class="form-control">
                <option value="">Select Locale</option>
                @foreach ($languages as $code => $language)
                    <option value="{{ $code }}" {{ old('locale', $user->profile->locale ?? '') == $code ? 'selected' : '' }}>
                        {{ $language }}
                    </option>
                @endforeach
            </select>
            @error('locale')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Submit Button -->
        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Update Profile</button>
        </div>
    </form>
</div>
@endsection
