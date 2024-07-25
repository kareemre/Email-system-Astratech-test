<!-- resources/views/emails/show.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Email Details</h1>
    <div class="card">
        <div class="card-header">
            From: {{ $email->from }}
        </div>
        <div class="card-body">
            <h5 class="card-title">Subject: {{ $email->subject }}</h5>
            <p class="card-text">{{ $email->body }}</p>
            <h5>Attachments:</h5>
            @foreach($email->attachments as $attachment)
                <a href="{{ Storage::url($attachment->file_path) }}" target="_blank">{{ $attachment->file_name }}</a><br>
            @endforeach
        </div>
        <div class="card-footer text-muted">
            Received At: {{ $email->created_at }}
        </div>
    </div>
    <a href="{{ route('inbox') }}" class="btn btn-secondary mt-3">Back to Inbox</a>
    <a href="{{ route('outbox') }}" class="btn btn-secondary mt-3">Back to Outbox</a>
@endsection
