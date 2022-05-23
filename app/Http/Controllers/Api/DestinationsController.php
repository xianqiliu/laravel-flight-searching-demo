<?php

namespace App\Http\Controllers\Api;

use Amadeus\Exceptions\ResponseException;
use App\Http\Resources\DestinationResource;
use Illuminate\Http\Request;

class DestinationsController extends AmadeusController
{
    /**
     * @throws ResponseException
     */
    public function getDirectDestinations(Request $request): array
    {
        $destinations = $this->amadeus->airport->directDestinations->get(
            array(
                "departureAirportCode" => $request->{'departureAirportCode'},
                "max" => $request->{'max'}
            )
        );

        return [
            "meta" => $destinations[0]->getResponse()->getBodyAsJsonObject()->{'meta'},
            "data" => DestinationResource::collection($destinations)
        ];
    }
}
