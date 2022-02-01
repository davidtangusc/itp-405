<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

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
        $artists = DB::table('artists')
            ->orderBy('name')
            ->get();

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
            'title' => $request->input('title'), // $_POST['title'] $_REQUEST['title']
            'artist_id' => $request->input('artist'),
        ]);

        return redirect()
            ->route('album.index')
            ->with('success', "Successfully created album {$request->input('title')}");

    }
}
