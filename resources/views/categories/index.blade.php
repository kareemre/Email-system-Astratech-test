<!-- resources/views/categories/index.blade.php -->
@extends('layouts.app')

@section('content')
    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Category Name:</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Category</button>
    </form>
    <h2 class="mt-5">Existing Categories</h2>
    <ul class="list-group">
        @foreach($categories as $category)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                {{ $category->name }}
                <form action="{{ route('categories.destroy', $category) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>
@endsection
