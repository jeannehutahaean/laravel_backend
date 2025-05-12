<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - @yield('title')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Admin Panel</a>
            <div class="d-flex">
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button class="btn btn-danger">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        @yield('content')
    </div>

</body>
</html>

