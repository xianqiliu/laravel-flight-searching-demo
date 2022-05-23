<?php

namespace App\Http\Controllers\Api;

use Amadeus\Exceptions\ResponseException;
use App\Http\Resources\FlightOfferResource;
use Illuminate\Http\Request;

class FlightOffersController extends AmadeusController
{
    /**
     * @throws ResponseException
     */
    public function getFlightOffers(Request $request): array
    {
        $flightOffers = $this->amadeus->shopping->flightOffers->get(
            array(
                "originLocationCode" => $request->{'originLocationCode'},
                "destinationLocationCode" => $request->{'destinationLocationCode'},
                "departureDate" => $request->{'departureDate'},
                "returnDate" => $request->{'returnDate'},
                "adults" => "1"
            )
        );

        return [
            "meta" => $flightOffers[0]->getResponse()->getBodyAsJsonObject()->{'meta'},
            "data" => FlightOfferResource::collection($flightOffers)
        ];
    }
}
