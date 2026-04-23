<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hospital CRUD System</title>
  <style>
    body { font-family: sans-serif; margin: 0; display: flex; min-height: 100vh; }
    
    /* Sidebar Styling */
    .sidebar { 
      width: 250px; 
      background: #343a40; 
      color: white; 
      padding: 20px 0;
      flex-shrink: 0;
    }
    .sidebar h2 { text-align: center; font-size: 1.2rem; margin-bottom: 20px; color: #fff; }
    .sidebar a { 
      display: block; 
      color: #adb5bd; 
      padding: 12px 20px; 
      text-decoration: none; 
      transition: 0.3s;
    }
    .sidebar a:hover { background: #495057; color: white; }
    .sidebar a.active { background: #007bff; color: white; }

    /* Main Content Area */
    .main-wrapper { flex-grow: 1; display: flex; flex-direction: column; }
    .navbar { background: #fff; padding: 15px 30px; border-bottom: 1px solid #ccc; display: flex; justify-content: space-between; }
    .container { padding: 30px; }

    /* Existing Styles */
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    table, th, td { border: 1px solid #ccc; }
    th, td { padding: 10px; text-align: left; }
    .btn { padding: 5px 10px; text-decoration: none; border: 1px solid #333; color: #333; background: #eee; border-radius: 3px; cursor: pointer; }
    .btn-primary { background: #007bff; color: white; border-color: #007bff; }
    .btn-danger { background: #dc3545; color: white; border-color: #dc3545; }
    .alert { padding: 15px; margin-bottom: 20px; border: 1px solid transparent; border-radius: 4px; }
    .alert-success { color: #155724; background-color: #d4edda; border-color: #c3e6cb; }
    .form-group { margin-bottom: 15px; }
    .form-group label { display: block; margin-bottom: 5px; }
    .form-control { width: 100%; padding: 8px; box-sizing: border-box; }
  </style>
</head>
<body>

  <aside class="sidebar">
    <h2>HMS Admin</h2>
    <nav>
      <a href="{{ route('departments.index') }}" class="{{ request()->is('departments*') ? 'active' : '' }}">Departments</a>
      <a href="{{ route('staff.index') }}" class="{{ request()->is('staff*') ? 'active' : '' }}">Medical Staff</a>
      <a href="{{ route('patients.index') }}" class="{{ request()->is('patients*') ? 'active' : '' }}">Patients</a>
      <a href="{{ route('schedules.index') }}" class="{{ request()->is('schedules*') ? 'active' : '' }}">Schedules</a>
      <a href="{{ route('appointments.index') }}" class="{{ request()->is('appointments*') ? 'active' : '' }}">Appointments</a>
      <a href="{{ route('invoices.index') }}" class="{{ request()->is('invoices*') ? 'active' : '' }}">Invoices</a>
      <hr style="border: 0.5px solid #495057; margin: 10px 0;">
      <a href="{{ route('user_accounts.index') }}" class="{{ request()->is('user_accounts*') ? 'active' : '' }}">User Accounts</a>
    </nav>
  </aside>

  <div class="main-wrapper">
    <header class="navbar">
      <strong>Dashboard</strong>
      <span>Welcome, {{ Auth::user()->email ?? 'Admin' }}</span>
    </header>

    <main class="container">
      @if(session('success'))
        <div class="alert alert-success">
          {{ session('success') }}
        </div>
      @endif

      @yield('content')
    </main>
  </div>

</body>
</html>