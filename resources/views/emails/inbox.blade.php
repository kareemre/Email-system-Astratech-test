<!-- resources/views/inbox.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Inbox</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>From</th>
                <th>Subject</th>
                <th>Body</th>
                <th>Attachments</th>
                <th>Categories</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($emails as $email)
                <tr>
                    <td>{{ $email->from }}</td>
                    <td>{{ $email->subject }}</td>
                    <td>{{ Str::limit($email->body, 50) }}</td>
                    <td>
                        @foreach($email->attachments as $attachment)
                            <a href="{{ Storage::url($attachment->file_path) }}" target="_blank">{{ $attachment->file_name }}</a><br>
                        @endforeach
                    </td>
                    <td>
                        <form action="{{ route('emails.categorize', $email) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <select  name="categories[]" multiple data-live-search="true">
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ in_array($category->id, $email->categories->pluck('id')->toArray()) ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">Categorize</button>
                        </form>
                        <ul class="mt-2">
                            @foreach($email->categories as $category)
                                <li>{{ $category->name }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>
                        <div class="btn-group" role="group">
                            <a href="{{ route('emails.show', $email) }}" class="btn btn-info btn-sm">View</a>
                            <a href="{{ route('show.reply.email', $email) }}" class="btn btn-primary btn-sm">Reply</a>
                            <a href="{{ route('show.forward.email', $email) }}" class="btn btn-secondary btn-sm">Forward</a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        $('.selectpicker').selectpicker();
    });
</script>
@endpush
