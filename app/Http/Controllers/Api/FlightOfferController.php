<?php

namespace App\Http\Controllers\Api;

use Amadeus\Exceptions\ResponseException;
use App\Http\Resources\AmadeusFlightOfferResource;
use Illuminate\Http\Request;

class FlightOfferController extends AmadeusController
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
            "data" => AmadeusFlightOfferResource::collection($flightOffers)
        ];
    }
}
