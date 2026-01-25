@extends('layouts.tenant-layout')

@section('content')
<div class="content-header">
    <h1>Edit Profile</h1>
    <p>Update your account information</p>
</div>

@if(session('success'))
    <div style="background-color: #d4edda; color: #155724; padding: 12px 20px; border-radius: 6px; margin-bottom: 20px; border-left: 4px solid #28a745;">
        {{ session('success') }}
    </div>
@endif

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
    <!-- Update Profile Information -->
    <div class="card">
        <h3 style="margin-bottom: 20px; font-size: 18px; color: #333;">Profile Information</h3>
        
        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PATCH')

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 500; font-size: 14px;">Name</label>
                <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" required 
                       style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                @error('name')
                    <p style="color: #dc3545; font-size: 13px; margin-top: 5px;">{{ $message }}</p>
                @enderror
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 500; font-size: 14px;">Email</label>
                <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" required 
                       style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                @error('email')
                    <p style="color: #dc3545; font-size: 13px; margin-top: 5px;">{{ $message }}</p>
                @enderror
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 500; font-size: 14px;">Phone Number</label>
                <input type="text" name="phone" value="{{ old('phone', Auth::user()->phone) }}" 
                       placeholder="e.g., 09123456789"
                       style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                @error('phone')
                    <p style="color: #dc3545; font-size: 13px; margin-top: 5px;">{{ $message }}</p>
                @enderror
            </div>

            <div style="margin-bottom: 25px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 500; font-size: 14px;">Emergency Contact</label>
                <input type="text" name="emergencyContact" value="{{ old('emergencyContact', Auth::user()->emergencyContact) }}" 
                       placeholder="Name and phone of emergency contact"
                       style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                @error('emergencyContact')
                    <p style="color: #dc3545; font-size: 13px; margin-top: 5px;">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" 
                    style="width: 100%; padding: 12px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 15px;">
                Save Changes
            </button>
        </form>
    </div>

    <!-- Update Password -->
    <div class="card">
        <h3 style="margin-bottom: 20px; font-size: 18px; color: #333;">Update Password</h3>
        
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            @method('PUT')

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 500; font-size: 14px;">Current Password</label>
                <input type="password" name="current_password" required 
                       style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                @error('current_password')
                    <p style="color: #dc3545; font-size: 13px; margin-top: 5px;">{{ $message }}</p>
                @enderror
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 500; font-size: 14px;">New Password</label>
                <input type="password" name="password" required 
                       style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                @error('password')
                    <p style="color: #dc3545; font-size: 13px; margin-top: 5px;">{{ $message }}</p>
                @enderror
            </div>

            <div style="margin-bottom: 25px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 500; font-size: 14px;">Confirm New Password</label>
                <input type="password" name="password_confirmation" required 
                       style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
            </div>

            <button type="submit" 
                    style="width: 100%; padding: 12px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 15px;">
                Update Password
            </button>
        </form>
    </div>
</div>

@endsection