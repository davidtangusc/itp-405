@extends("layouts.main")

@section("title", "Albums")

@section("content")
    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-3 text-end">
        <a href="{{ route('album.create') }}">New Album</a>
    </div>

    @livewire('search-albums')
@endsection