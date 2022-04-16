<div>
    <input wire:model="search" type="text" placeholder="Search albums..." />

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Album</th>
                <th colspan="2">Artist</th>
            </tr>
        </thead>
        <tbody>
            @foreach($albums as $album)
                <tr>
                    <td>
                        {{$album->title}}
                    </td>
                    <td>
                        {{$album->artist}}
                    </td>
                    <td>
                        <a href="{{ route('album.edit', [ 'id' => $album->id ]) }}">
                            Edit
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
