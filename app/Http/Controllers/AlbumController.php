<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlbumController extends Controller
{
    public function index()
    {
        $albums = DB::table('albums')
            ->join('artists', 'albums.artist_id', '=', 'artists.id')
            ->orderBy('artist')
            ->orderBy('title')
            ->get([
                'albums.title',
                'artists.name AS artist',
            ]);

        return view('album.index', [
            'albums' => $albums,
        ]);
    }

    public function create()
    {
        $artists = DB::table('artists')->orderBy('name')->get();

        return view('album.create', [
            'artists' => $artists,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:20',
            'artist' => 'required|exists:artists,id',
        ]);

        DB::table('albums')->insert([
            'title' => $request->input('title'),
            'artist_id' => $request->input('artist'),
        ]);

        $artist = DB::table('artists')
            ->where('id', '=', $request->input('artist'))
            ->first();

        return redirect()
            ->route('albums.index')
            ->with('success', "Successfully created {$artist->name} - {$request->input('title')}");
    }
}