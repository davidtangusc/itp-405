<?php

namespace App\Http\Livewire;

use Livewire\Component;
use DB;

class SearchAlbums extends Component
{
    public $search = '';

    public function render()
    {
        $query = DB::table('albums')
            ->join('artists', 'albums.artist_id', '=', 'artists.id')
            ->orderBy('artist')
            ->orderBy('title');
        
        if ($this->search) {
            $query
                ->where('albums.title', 'LIKE', '%' . $this->search . '%')
                ->orWhere('artists.name', 'LIKE', '%' . $this->search . '%');
        }

        $albums = $query->get([
            'albums.id',
            'albums.title',
            'artists.name AS artist',
        ]);

        return view('livewire.search-albums', [
            'albums' => $albums,
        ]);
    }
}
