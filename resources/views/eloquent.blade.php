@extends('layouts.main')

@section('title', 'Eloquent Playground')

@section('content')
  <table class="table">
    <tr>
      <th>Track</th>
      <th>Genre</th>
    </tr>

    @foreach ($tracks as $track)
      <tr>
        <td>{{$track->name}}</td>
        <td>{{$track->genre->name}}</td>
      </tr>
    @endforeach
  </table>
@endsection