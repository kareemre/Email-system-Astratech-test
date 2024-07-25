<!-- resources/views/partials/navbar.blade.php -->
<nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
    <a class="navbar-brand" href="#">Email App</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('inbox') }}">Inbox</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('outbox') }}">Outbox</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('categories.index') }}">Create Category</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('show.send.email') }}">Send Email</a>
            </li>

        </ul>
    </div>
</nav>