<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AlbumResource extends JsonResource
{
    public static $wrap = 'album';

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'title' => $this->title,
            'artist_id' => $this->artist_id,
        ];
    }

    public function with($request)
    {
        // $this proxies to $album that was passed in
        $sideloadedData = [];

        if ($request->query('include')) {
            $relationshipsToSideload = explode(',', $request->query('include')); // ['artist', 'tracks]

            foreach ($relationshipsToSideload as $relationship) {
                if ($this->$relationship()->exists()) { // $album->tracks()->exists()
                    $sideloadedData[$relationship] = $this->$relationship;
                }
            }
        }

        return $sideloadedData;
    }
}
