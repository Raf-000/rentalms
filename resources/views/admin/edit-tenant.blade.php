@extends('layouts.admin-layout')

@section('content')
<div class="content-header">
    <h1>Edit Tenant</h1>
    <p>Update tenant information and bedspace assignment</p>
</div>

@if(session('success'))
    <div style="background-color: #d4edda; color: #155724; padding: 12px 20px; border-radius: 6px; margin-bottom: 20px; border-left: 4px solid #28a745;">
        {{ session('success') }}
    </div>
@endif

<div style="background: white; padding: 30px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); max-width: 600px;">
    <form method="POST" action="{{ route('admin.update-tenant', $tenant->id) }}">
        @csrf
        @method('PUT')

        <!-- Name -->
        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 500; font-size: 14px;">Full Name</label>
            <input type="text" name="name" value="{{ old('name', $tenant->name) }}" required
                   style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px;">
            @error('name')
                <p style="color: #dc3545; font-size: 13px; margin-top: 5px;">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email -->
        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 500; font-size: 14px;">Email</label>
            <input type="email" name="email" value="{{ old('email', $tenant->email) }}" required
                   style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px;">
            @error('email')
                <p style="color: #dc3545; font-size: 13px; margin-top: 5px;">{{ $message }}</p>
            @enderror
        </div>

        <!-- Phone -->
        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 500; font-size: 14px;">Phone</label>
            <input type="text" name="phone" value="{{ old('phone', $tenant->phone) }}" required
                   style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px;">
            @error('phone')
                <p style="color: #dc3545; font-size: 13px; margin-top: 5px;">{{ $message }}</p>
            @enderror
        </div>

        <!-- Bedspace Assignment -->
        <div style="margin-bottom: 30px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 500; font-size: 14px;">Assigned Bedspace</label>
            <select name="bedspace_id" 
                    style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px;">
                <option value="">No bedspace assigned</option>
                @foreach($bedspaces as $bedspace)
                    <option value="{{ $bedspace->unitID }}" 
                            {{ old('bedspace_id', $tenant->bedspace?->unitID) == $bedspace->unitID ? 'selected' : '' }}>
                        {{ $bedspace->unitCode }} - House {{ $bedspace->houseNo }}, Floor {{ $bedspace->floor }}, Room {{ $bedspace->roomNo }}, Bed {{ $bedspace->bedspaceNo }} (₱{{ number_format($bedspace->price, 0) }})
                    </option>
                @endforeach
            </select>
            @error('bedspace_id')
                <p style="color: #dc3545; font-size: 13px; margin-top: 5px;">{{ $message }}</p>
            @enderror
            
            @if($tenant->bedspace)
                <p style="font-size: 13px; color: #666; margin-top: 8px;">
                    Current: {{ $tenant->bedspace->unitCode }}
                </p>
            @endif
        </div>

        <!-- Buttons -->
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('admin.view-tenants') }}" 
               style="flex: 1; padding: 12px; background-color: #6c757d; color: white; border: none; border-radius: 6px; text-decoration: none; text-align: center; font-size: 15px;">
                Cancel
            </a>
            <button type="submit" 
                    style="flex: 1; padding: 12px; background-color: #007bff; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 15px;">
                Save Changes
            </button>
        </div>
    </form>
</div>
@endsection