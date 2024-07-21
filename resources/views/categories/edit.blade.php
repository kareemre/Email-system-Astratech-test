<!-- resources/views/categories/edit.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Edit Category</h1>
    <form action="{{ route('categories.update', $category) }}" method="POST" class="form-horizontal">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name" class="control-label">Name:</label>
            <input type="text" name="name" value="{{ $category->name }}" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="keywords" class="control-label">Keywords (comma-separated):</label>
            <input type="text" name="keywords" value="{{ $category->keywords->pluck('keyword')->implode(', ') }}" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Update</button>
    </form>
@endsection
