<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CRUD System</title>
  <style>
    body { font-family: sans-serif; padding: 20px; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    table, th, td { border: 1px solid #ccc; }
    th, td { padding: 10px; text-align: left; }
    .btn { padding: 5px 10px; text-decoration: none; border: 1px solid #333; color: #333; background: #eee; border-radius: 3px; }
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
  <div class="container">
    @yield('content')
  </div>
</body>
</html>