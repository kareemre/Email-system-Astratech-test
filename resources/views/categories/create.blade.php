<!-- resources/views/categories/create.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Create Category</h1>
    <form action="{{ route('categories.store') }}" method="POST" class="form-horizontal">
        @csrf
        <div class="form-group">
            <label for="name" class="control-label">Name:</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="keywords" class="control-label">Keywords (comma-separated):</label>
            <input type="text" name="keywords" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Create</button>
    </form>
@endsection
