<!-- resources/views/send_email.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Send Email</h1>
    <form action="{{ route('send.email') }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
        @csrf
        <div class="form-group">
            <label for="to" class="control-label">To:</label>
            <input type="email" name="to" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="subject" class="control-label">Subject:</label>
            <input type="text" name="subject" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="body" class="control-label">Body:</label>
            <textarea name="body" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label for="attachments" class="control-label">Attachments:</label>
            <input type="file" name="attachments[]" multiple class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Send</button>
    </form>
@endsection
