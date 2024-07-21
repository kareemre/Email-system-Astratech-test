<!-- resources/views/inbox.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Inbox</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>From</th>
                <th>Subject</th>
                <th>Received At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($emails as $email)
                <tr>
                    <td>{{ $email->from }}</td>
                    <td>{{ $email->subject }}</td>
                    <td>{{ $email->created_at }}</td>
                    <td>
                        <a href="{{ route('show.reply.email', $email) }}" class="btn btn-primary btn-sm">Reply</a>
                        <a href="{{ route('show.forward.email', $email) }}" class="btn btn-secondary btn-sm">Forward</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
