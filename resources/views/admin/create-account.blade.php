@extends('layouts.admin-layout')

@section('content')
<div class="content-header">
    <h1>Create New Account</h1>
    <p>Add new admin or tenant accounts</p>
</div>

<div class="card" style="max-width: 600px;">
    <form method="POST" action="{{ route('admin.store-account') }}">
        @csrf

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 500;">Name</label>
            <input type="text" name="name" required 
                   style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
            @error('name')
                <p style="color: red; font-size: 13px; margin-top: 5px;">{{ $message }}</p>
            @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 500;">Email</label>
            <input type="email" name="email" required 
                   style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
            @error('email')
                <p style="color: red; font-size: 13px; margin-top: 5px;">{{ $message }}</p>
            @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 500;">Password</label>
            <input type="password" name="password" required 
                   style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
            @error('password')
                <p style="color: red; font-size: 13px; margin-top: 5px;">{{ $message }}</p>
            @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 500;">Account Type</label>
            <select name="role" id="role" required 
                    style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                <option value="">Select Role</option>
                <option value="admin">Admin</option>
                <option value="tenant">Tenant</option>
            </select>
            @error('role')
                <p style="color: red; font-size: 13px; margin-top: 5px;">{{ $message }}</p>
            @enderror
        </div>

        <div id="bedspace-section" style="display: none; margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 500;">Assign Bedspace (Optional)</label>
            <select name="bedspace_id" id="bedspace_id" 
                    style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                <option value="">No bedspace assigned</option>
                @foreach($bedspaces as $bedspace)
                    <option value="{{ $bedspace->unitID }}">
                        {{ $bedspace->unitCode }} - ₱{{ number_format($bedspace->price, 2) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div id="lease-section" style="display: none;">
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 500;">Lease Start Date</label>
                <input type="date" name="leaseStart" 
                       style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                @error('leaseStart')
                    <p style="color: red; font-size: 13px; margin-top: 5px;">{{ $message }}</p>
                @enderror
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 500;">Lease End Date</label>
                <input type="date" name="leaseEnd" 
                       style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                @error('leaseEnd')
                    <p style="color: red; font-size: 13px; margin-top: 5px;">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <button type="submit" 
                style="padding: 10px 25px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 15px;">
            Create Account
        </button>
    </form>
</div>

<!-- Success Notification Popup (Top notification style) -->
@if(session('success') && session('user'))
<div id="successNotification" style="position: fixed; top: 80px; right: 30px; z-index: 1000; animation: slideIn 0.3s ease-out;">
    <div style="background: white; border-radius: 8px; box-shadow: 0 4px 20px rgba(0,0,0,0.15); max-width: 400px; border-left: 4px solid #28a745;">
        <div style="padding: 20px;">
            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 15px;">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <div style="width: 32px; height: 32px; background-color: #d4edda; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <span style="color: #28a745; font-size: 18px;">✓</span>
                    </div>
                    <h3 style="font-size: 16px; font-weight: 600; color: #333; margin: 0;">Account Created!</h3>
                </div>
                <button onclick="closeNotification()" style="background: none; border: none; font-size: 20px; color: #999; cursor: pointer; padding: 0; line-height: 1;">&times;</button>
            </div>
            
            <div style="background-color: #f8f9fa; padding: 15px; border-radius: 6px; margin-bottom: 12px;">
                <div style="margin-bottom: 10px;">
                    <p style="font-size: 11px; color: #666; margin: 0 0 3px 0;">Name</p>
                    <p style="font-size: 14px; font-weight: 500; color: #333; margin: 0;">{{ session('user')['name'] }}</p>
                </div>
                <div style="margin-bottom: 10px;">
                    <p style="font-size: 11px; color: #666; margin: 0 0 3px 0;">Email (Username)</p>
                    <p style="font-size: 14px; font-weight: 500; color: #333; margin: 0;">{{ session('user')['email'] }}</p>
                </div>
                <div style="margin-bottom: 10px;">
                    <p style="font-size: 11px; color: #666; margin: 0 0 3px 0;">Password</p>
                    <p style="font-size: 14px; font-weight: 500; color: #333; margin: 0;">{{ session('user')['password'] }}</p>
                </div>
                <div>
                    <p style="font-size: 11px; color: #666; margin: 0 0 3px 0;">Role</p>
                    <p style="font-size: 14px; font-weight: 500; color: #333; margin: 0;">{{ session('user')['role'] }}</p>
                </div>
            </div>

            <p style="font-size: 12px; color: #666; text-align: center; margin: 0 0 12px 0;">
                Screenshot and send to the user
            </p>

            <button onclick="closeNotification()" 
                    style="width: 100%; padding: 10px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 14px;">
                Close
            </button>
        </div>
    </div>
</div>

<style>
    @keyframes slideIn {
        from {
            transform: translateX(400px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
</style>

<script>
    // Auto close after 20 seconds
    setTimeout(function() {
        closeNotification();
    }, 20000);

    function closeNotification() {
        var notification = document.getElementById('successNotification');
        if (notification) {
            notification.style.animation = 'slideOut 0.3s ease-out';
            setTimeout(function() {
                notification.style.display = 'none';
            }, 300);
        }
    }
</script>

<style>
    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(400px);
            opacity: 0;
        }
    }
</style>
@endif

<script>
    // Show bedspace and lease sections only when Tenant is selected
    document.getElementById('role').addEventListener('change', function() {
        const bedspaceSection = document.getElementById('bedspace-section');
        if (this.value === 'tenant') {
            bedspaceSection.style.display = 'block';
        } else {
            bedspaceSection.style.display = 'none';
            document.getElementById('lease-section').style.display = 'none';
        }
    });

    // Show lease dates when a bedspace is selected
    document.getElementById('bedspace_id').addEventListener('change', function() {
        const leaseSection = document.getElementById('lease-section');
        if (this.value) {
            leaseSection.style.display = 'block';
        } else {
            leaseSection.style.display = 'none';
        }
    });
</script>

@endsection