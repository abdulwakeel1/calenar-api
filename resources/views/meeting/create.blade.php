@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Create Meeting</h2>
        <form action="{{ route('meeting.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="subject">Subject:</label>
                <input type="text" class="form-control" name="subject" value="{{ old('subject') }}">
                @error('subject')
                    <span class="text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="date">Date:</label>
                <input type="date" class="form-control" name="date" value="{{ old('date') }}">
                @error('date')
                    <span class="text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="time">Time:</label>
                <input type="time" class="form-control" name="time" value="{{ old('time') }}">
                @error('time')
                    <span class="text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="attendees">Attendees (maximum 2):</label>
                <input type="email" class="form-control" name="attendees[]" value="{{ old('attendees.0') }}">
                <input type="email" class="form-control mt-2" name="attendees[]" value="{{ old('attendees.1') }}">
                @error('attendees.0')
                    <span class="text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary mt-2">Create</button>
        </form>
    </div>
@endsection
