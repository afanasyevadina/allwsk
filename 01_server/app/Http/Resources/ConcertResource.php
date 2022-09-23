<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ConcertResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'artist' => $this->artist,
            'location' => [
                'id' => $this->location->id,
                'name' => $this->location->name,
            ],
            'shows' => $this->shows()->orderBy('start')->get()->map(function($show) {
                return [
                    'id' => $show->id,
                    'start' => Carbon::create($show->start)->subHours(7)->toIso8601ZuluString(),
                    'end' => Carbon::create($show->end)->subHours(7)->toIso8601ZuluString(),
                ];
            }),
        ];
    }
}
