<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SeatingResource extends JsonResource
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
            'name' => $this->name,
            'seats' => [
                'total' => $this->locationSeats()->count(),
                'unavailable' => $this->locationSeats()->where(function ($query) {
                    $query->whereNotNull('reservation_id')->orWhereNotNull('ticket_id');
                })->orderBy('number')->get()->map(function($seat) {
                    return $seat->number;
                }),
            ],
        ];
    }
}
