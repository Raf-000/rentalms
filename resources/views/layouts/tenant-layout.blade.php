<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tenant Dashboard - Rental Management</title>
    @yield('extra-css')
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }

        /* Header */
        .header {
            background-color: #135757;
            border-bottom: 1px solid #ddd;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
            height: 60px;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logo {
            font-size: 20px;
            font-weight: bold;
            color: white;
            text-decoration: none;
        }

        .header-right {
            position: relative;
        }

        .user-menu {
            cursor: pointer;
            padding: 8px 15px;
            background-color: #f0f0f0;
            border-radius: 5px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .user-menu:hover {
            background-color: #e0e0e0;
        }

        .dropdown a,
        .dropdown button {
            display: block;
            padding: 10px 15px;
            text-decoration: none;
            color: #333;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
            font-size: 14px;       /* ensure same font size */
            font-family: inherit;  /* inherit same font family */
        }


        .dropdown {
            display: none;
            position: absolute;
            right: 0;
            top: 45px;
            background: white;
            border: 1px solid #ddd;
            border-radius: 5px;
            min-width: 150px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .dropdown.show {
            display: block;
        }

        .dropdown a, .dropdown button {
            display: block;
            padding: 10px 15px;
            text-decoration: none;
            color: #333;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
        }

        .dropdown a:hover, .dropdown button:hover {
            background-color: #f5f5f5;
        }

        /* Main Content */
        .main-content {
            margin-top: 60px;
            padding: 30px;
            min-height: calc(100vh - 60px);
            display: flex;
            gap: 30px;
        }

        /* Profile Card (Left - 45%) */
        .profile-card {
            width: 45%;
            max-width: 400px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            overflow: hidden;
            height: fit-content;
            position: sticky;
            top: 90px;
        }

        .profile-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px 30px 30px;
            text-align: center;
            color: white;
        }

        .profile-avatar {
            width: 100px;
            height: 100px;
            background-color: white;
            border-radius: 50%;
            margin: 0 auto 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            font-weight: bold;
            color: #667eea;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }

        .profile-name {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .profile-bedspace {
            font-size: 16px;
            margin-bottom: 5px;
            opacity: 0.95;
        }

        .profile-bedspace-details {
            font-size: 13px;
            opacity: 0.8;
        }

        .profile-nav {
            padding: 0;
        }

        .profile-nav a {
            display: block;
            padding: 15px 25px;
            text-decoration: none;
            color: #555;
            border-bottom: 1px solid #f0f0f0;
            transition: all 0.2s;
            font-size: 14px;
        }

        .profile-nav a:last-child {
            border-bottom: none;
        }

        .profile-nav a:hover {
            background-color: #f8f9fa;
            color: #007bff;
            padding-left: 30px;
        }

        .profile-nav a.active {
            background-color: #e3f2fd;
            color: #007bff;
            border-left: 4px solid #007bff;
            font-weight: 500;
        }

        /* Content Area (Right - 55%) */
        .content-area {
            flex: 1;
            min-width: 0;
        }

        .content-header {
            margin-bottom: 25px;
        }

        .content-header h1 {
            font-size: 28px;
            color: #333;
            margin-bottom: 8px;
        }

        .content-header p {
            color: #666;
            font-size: 14px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="header-left">
            <a href="{{ route('tenant.dashboard') }}" class="logo">BOARDING HOMES</a>
        </div>
        <div class="header-right">
            <div class="user-menu" onclick="toggleDropdown()">
                <span>{{ Auth::user()->name }}</span>
                <span>▼</span>
            </div>
            <div id="userDropdown" class="dropdown">
                <a href="{{ route('profile.edit') }}">Edit Profile</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="main-content">
        <!-- Profile Card (Left Side) -->
        <div class="profile-card">
            @php
                $tenant = Auth::user();
                $bedspace = $tenant->bedspace;
                $initials = strtoupper(substr($tenant->name, 0, 1));
            @endphp
            
            <div class="profile-header">
                <div class="profile-avatar">{{ $initials }}</div>
                <div class="profile-name">{{ $tenant->name }}</div>
                @if($bedspace)
                    <div class="profile-bedspace">Slot: {{ $bedspace->unitCode }}</div>
                    <div class="profile-bedspace-details">
                        House {{ $bedspace->houseNo }} • Room {{ $bedspace->roomNo }} • Bed #{{ $bedspace->bedspaceNo }}
                    </div>
                @else
                    <div class="profile-bedspace-details">No bedspace assigned</div>
                @endif
            </div>
            
            <div class="profile-nav">
                <a href="{{ route('tenant.dashboard') }}" 
                   class="{{ request()->routeIs('tenant.dashboard') ? 'active' : '' }}">
                    Tenant Dashboard
                </a>
                <a href="{{ route('tenant.view-bills') }}" 
                   class="{{ request()->routeIs('tenant.view-bills') || request()->routeIs('tenant.upload-payment') ? 'active' : '' }}">
                    Pay Bills
                </a>
                <a href="{{ route('tenant.view-maintenance') }}" 
                   class="{{ request()->routeIs('tenant.view-maintenance') || request()->routeIs('tenant.create-maintenance') ? 'active' : '' }}">
                    Maintenance Report
                </a>
            </div>
        </div>

        <!-- Content Area (Right Side) -->
        <div class="content-area">
            @yield('content')
        </div>
    </div>

    <script>
        function toggleDropdown() {
            document.getElementById('userDropdown').classList.toggle('show');
        }

        // Close dropdown when clicking outside
        window.onclick = function(event) {
            if (!event.target.closest('.user-menu')) {
                var dropdown = document.getElementById('userDropdown');
                if (dropdown.classList.contains('show')) {
                    dropdown.classList.remove('show');
                }
            }
        }
    </script>

    @yield('scripts')
</body>
</html>