@extends('layouts.admin-layout')

@section('content')
<div class="content-header">
    <h1>Issue New Bill</h1>
    <p>Create a custom bill for a tenant</p>
</div>

<div style="background: white; padding: 30px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); max-width: 600px;">
    <form method="POST" action="{{ route('admin.bills.store') }}">
        @csrf

        <!-- Tenant Selection -->
        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 500; font-size: 14px;">Select Tenant *</label>
            <select name="tenantID" required
                    style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px;">
                <option value="">Choose a tenant</option>
                @foreach($tenants as $tenant)
                    <option value="{{ $tenant->id }}" {{ old('tenantID') == $tenant->id ? 'selected' : '' }}>
                        {{ $tenant->name }} - {{ $tenant->bedspace?->unitCode ?? 'No bedspace' }}
                    </option>
                @endforeach
            </select>
            @error('tenantID')
                <p style="color: #dc3545; font-size: 13px; margin-top: 5px;">{{ $message }}</p>
            @enderror
        </div>

        <!-- Amount -->
        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 500; font-size: 14px;">Amount *</label>
            <input type="number" name="amount" step="0.01" min="0" value="{{ old('amount') }}" required
                   placeholder="0.00"
                   style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px;">
            @error('amount')
                <p style="color: #dc3545; font-size: 13px; margin-top: 5px;">{{ $message }}</p>
            @enderror
        </div>

        <!-- Description -->
        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 500; font-size: 14px;">Description (Optional)</label>
            <textarea name="description" rows="3"
                      placeholder="E.g., Monthly rent, Penalty for late payment, Broken window repair..."
                      style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-family: Arial, sans-serif; font-size: 14px;">{{ old('description') }}</textarea>
            @error('description')
                <p style="color: #dc3545; font-size: 13px; margin-top: 5px;">{{ $message }}</p>
            @enderror
            <p style="font-size: 12px; color: #666; margin-top: 5px;">Leave blank for regular monthly rent</p>
        </div>

        <!-- Due Date -->
        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 500; font-size: 14px;">Due Date *</label>
            <input type="date" name="dueDate" value="{{ old('dueDate', date('Y-m-d')) }}" required
                   style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px;">
            @error('dueDate')
                <p style="color: #dc3545; font-size: 13px; margin-top: 5px;">{{ $message }}</p>
            @enderror
        </div>

        <!-- Status -->
        <div style="margin-bottom: 30px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 500; font-size: 14px;">Status *</label>
            <select name="status" required
                    style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px;">
                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="paid" {{ old('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                <option value="verified" {{ old('status') == 'verified' ? 'selected' : '' }}>Verified</option>
            </select>
            @error('status')
                <p style="color: #dc3545; font-size: 13px; margin-top: 5px;">{{ $message }}</p>
            @enderror
        </div>

        <!-- Buttons -->
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('admin.bills.index') }}" 
               style="flex: 1; padding: 12px; background-color: #6c757d; color: white; border: none; border-radius: 6px; text-decoration: none; text-align: center; font-size: 15px;">
                Cancel
            </a>
            <button type="submit" 
                    style="flex: 1; padding: 12px; background-color: #007bff; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 15px;">
                Issue Bill
            </button>
        </div>
    </form>
</div>
@endsection