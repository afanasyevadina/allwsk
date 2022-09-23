<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class EventDetailResource extends JsonResource
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
            'slug' => $this->slug,
            'date' => $this->date,
            'channels' => $this->channels->map(function($channel) {
                return [
                    'id' => $channel->id,
                    'name' => $channel->name,
                    'rooms' => $channel->rooms->map(function($room) {
                        return [
                            'id' => $room->id,
                            'name' => $room->name,
                            'sessions' => $room->sessions->map(function($session) {
                                return [
                                    'id' => $session->id,
                                    'title' => $session->title,
                                    'description' => $session->description,
                                    'speaker' => $session->speaker,
                                    'start' => $session->start,
                                    'end' => $session->end,
                                    'type' => $session->type,
                                    'cost' => $session->cost,
                                ];
                            }),
                        ];
                    }),
                ];
            }),
            'tickets' => $this->tickets->map(function($ticket) {
                return [
                    'id' => $ticket->id,
                    'name' => $ticket->name,
                    'cost' => round($ticket->cost),
                    'description' => $ticket->description,
                    'available' => $ticket->available,
                ];
            }),
        ];
    }

    public static $wrap = null;
}
