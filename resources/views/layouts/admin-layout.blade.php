<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Rental Management</title>
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
            background-color: white;
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
            color: #333;
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

        /* Sidebar */
        .sidebar {
            position: fixed;
            left: 0;
            top: 60px;
            bottom: 0;
            width: 250px;
            background-color: white;
            border-right: 1px solid #ddd;
            overflow-y: auto;
            padding: 20px 0;
        }

        .sidebar-nav {
            list-style: none;
        }

        .sidebar-nav li {
            margin-bottom: 5px;
        }

        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 25px;
            text-decoration: none;
            color: #555;
            transition: all 0.2s;
        }

        .sidebar-nav a:hover {
            background-color: #f5f5f5;
            color: #007bff;
        }

        .sidebar-nav a.active {
            background-color: #e3f2fd;
            color: #007bff;
            border-right: 3px solid #007bff;
        }

        .nav-icon {
            width: 20px;
            height: 20px;
        }

        /* Main Content */
        .main-content {
            margin-left: 250px;
            margin-top: 60px;
            padding: 30px;
            min-height: calc(100vh - 60px);
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

        /* Utility Classes */
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
            <a href="{{ route('admin.dashboard') }}" class="logo">BOARDING HOMES</a>
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

    <!-- Sidebar -->
    <div class="sidebar">
        <ul class="sidebar-nav">
            <li>
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('admin.create-account') }}" class="{{ request()->routeIs('admin.create-account') ? 'active' : '' }}">
                    <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                    Create Account
                </a>
            </li>
            <li>
                <a href="{{ route('admin.view-tenants') }}" class="{{ request()->routeIs('admin.view-tenants') ? 'active' : '' }}">
                    <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    View Tenants
                </a>
            </li>
            <li>
                <a href="{{ route('admin.issue-bill') }}" class="{{ request()->routeIs('admin.issue-bill') ? 'active' : '' }}">
                    <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Issue Bills
                </a>
            </li>
            <li>
                <a href="{{ route('admin.view-payments') }}" class="{{ request()->routeIs('admin.view-payments') ? 'active' : '' }}">
                    <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Verify Payments
                </a>
            </li>
            <li>
                <a href="{{ route('admin.view-maintenance') }}" class="{{ request()->routeIs('admin.view-maintenance') ? 'active' : '' }}">
                    <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Maintenance
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content Area -->
    <div class="main-content">
        @yield('content')
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
</body>
</html>