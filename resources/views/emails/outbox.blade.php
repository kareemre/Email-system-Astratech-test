<!-- resources/views/outbox.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Outbox</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>To</th>
                <th>Subject</th>
                <th>Body</th>
                <th>Attachments</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($emails as $email)
                <tr>
                    <td>{{ $email->to }}</td>
                    <td>{{ $email->subject }}</td>
                    <td>{{ Str::limit($email->body, 50) }}</td>
                    <td>
                        @foreach($email->attachments as $attachment)
                            <a href="{{ Storage::url($attachment->file_path) }}" target="_blank">{{ $attachment->file_name }}</a><br>
                        @endforeach
                    </td>
                    <td>
                        <div class="btn-group" role="group">
                            <a href="{{ route('emails.show', $email) }}" class="btn btn-info btn-sm">View</a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
