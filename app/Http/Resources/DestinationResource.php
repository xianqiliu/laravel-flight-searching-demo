<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class DestinationResource extends AmadeusResource
{
    // Custom Function
//    /**
//     * Transform the resource into an array.
//     *
//     * @param  Request  $request
//     * @return array
//     */
//    public function toArray($request): array
//    {
//        return [
//            'type' => $this->getType(),
//            'subtype' => $this->getSubtype(),
//            'name' => $this->getName(),
//            'iataCode' => $this->getIataCode(),
//            'response' => $this->getResponse()->getResult()
//        ];
//    }
}
