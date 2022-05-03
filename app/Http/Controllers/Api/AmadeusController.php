<?php

namespace App\Http\Controllers\Api;

require_once 'C:\wamp64\www\laravel-flight-searching-demo\vendor\autoload.php';

use Amadeus\Amadeus;
use Amadeus\Exceptions\ResponseException;
use App\Http\Controllers\Controller;
use App\Http\Resources\AmadeusDestinationResource;
use App\Http\Resources\AmadeusFlightOfferResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AmadeusController extends Controller
{

    private Amadeus $client;

    public function __construct()
    {
        $this->client
            = Amadeus::builder("mUILmLsDW8L3N2ewWJcYqlPrwAmvzAJc", "l1DXxkVb3IOMQaN1")->build();
    }

    /**
     * @throws ResponseException
     */
    public function getDirectDestinations(Request $request): AnonymousResourceCollection
    {
        $destinations = $this->client->airport->directDestinations->get(
            array(
                "departureAirportCode" => $request->{'departureAirportCode'},
                "max" => $request->{'max'}
            )
        );
        return AmadeusDestinationResource::collection($destinations);
    }

    /**
     * @throws ResponseException
     */
    public function getFlightOffers(Request $request): AnonymousResourceCollection
    {
        $flightOffers = $this->client->shopping->flightOffers->get(
            array(
                "originLocationCode" => $request->{'originLocationCode'},
                "destinationLocationCode" => $request->{'destinationLocationCode'},
                "departureDate" => $request->{'departureDate'},
                "returnDate" => $request->{'returnDate'},
                "adults" => "1"
            )
        );

        return AmadeusFlightOfferResource::collection($flightOffers);
    }
}
