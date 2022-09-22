<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class RegistrationResource extends JsonResource
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
            'event' => [
                'id' => $this->ticket->event->id,
                'name' => $this->ticket->event->name,
                'slug' => $this->ticket->event->slug,
                'date' => $this->ticket->event->date,
                'organizer' => [
                    'id' => $this->ticket->event->organizer->id,
                    'name' => $this->ticket->event->organizer->name,
                    'slug' => $this->ticket->event->organizer->slug,
                ],
            ],
            'session_ids' => $this->sessionRegistrations->pluck('session_id'),
        ];
    }
}
