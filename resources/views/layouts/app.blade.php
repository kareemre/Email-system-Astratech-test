<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Your Application</title>
    <!-- Add Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Add Bootstrap Select CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.14/css/bootstrap-select.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <!-- Navbar -->
        @include('partials.navbar')

        <!-- Session Messages -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @yield('content')
    </div>

    <!-- Add jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <!-- Add Popper.js (required for Bootstrap) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>

    <!-- Add Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Add Bootstrap Select JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.14/js/bootstrap-select.min.js"></script>

    @stack('scripts')
</body>
</html>
