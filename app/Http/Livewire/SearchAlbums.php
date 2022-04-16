<?php

namespace App\Http\Livewire;

use Livewire\Component;
use DB;

class SearchAlbums extends Component
{
    public function render()
    {
        $albums = DB::table('albums')
            ->join('artists', 'albums.artist_id', '=', 'artists.id')
            ->orderBy('artist')
            ->orderBy('title')
            ->get([
                'albums.id',
                'albums.title',
                'artists.name AS artist',
            ]);

        return view('livewire.search-albums', [
            'albums' => $albums,
        ]);
    }
}
