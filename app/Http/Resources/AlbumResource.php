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
        return $this->attributesToArray();
    }

    public function with($request)
    {
        $sideloadedData = [];

        if ($request->query('include')) {
            $relationshipsToSideload = explode(',', $request->query('include'));

            foreach ($relationshipsToSideload as $relationship) {
                if ($this->$relationship()->exists()) {
                    $sideloadedData[$relationship] = $this->$relationship;
                }
            }
        }

        return $sideloadedData;
    }
}
