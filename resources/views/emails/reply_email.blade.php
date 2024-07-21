<!-- resources/views/reply_email.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Reply to Email</h1>
    <form action="{{ route('reply.email', $email) }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
        @csrf
        <div class="form-group">
            <label for="body" class="control-label">Body:</label>
            <textarea name="body" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label for="attachments" class="control-label">Attachments:</label>
            <input type="file" name="attachments[]" multiple class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Reply</button>
    </form>
@endsection
