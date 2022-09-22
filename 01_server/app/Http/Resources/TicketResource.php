<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
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
            'code' => $this->code,
            'name' => $this->booking->name,
            'created_at' => Carbon::create($this->created_at)->toIso8601ZuluString(),
            'row' => [
                'id' => $this->locationSeat?->locationSeatRow->id,
                'name' => $this->locationSeat?->locationSeatRow->name,
            ],
            'seat' => $this->locationSeat?->number,
            'show' => [
                'id' => $this->locationSeat?->locationSeatRow->show->id,
                'start' => Carbon::create($this->locationSeat?->locationSeatRow->show->start)->toIso8601ZuluString(),
                'end' => Carbon::create($this->locationSeat?->locationSeatRow->show->end)->toIso8601ZuluString(),
                'concert' => [
                    'id' => $this->locationSeat?->locationSeatRow->show->concert->id,
                    'artist' => $this->locationSeat?->locationSeatRow->show->concert->artist,
                    'location' => [
                        'id' => $this->locationSeat?->locationSeatRow->show->concert->location->id,
                        'name' => $this->locationSeat?->locationSeatRow->show->concert->location->name,
                    ],
                ],
            ],
        ];
    }
}
