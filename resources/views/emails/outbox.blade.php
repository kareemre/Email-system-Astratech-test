<!-- resources/views/outbox.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Outbox</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>To</th>
                <th>Subject</th>
                <th>Sent At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($emails as $email)
                <tr>
                    <td>{{ $email->to }}</td>
                    <td>{{ $email->subject }}</td>
                    <td>{{ $email->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
