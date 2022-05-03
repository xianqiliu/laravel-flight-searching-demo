<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class AmadeusDestinationResource extends JsonResource
{
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

    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
