<?php
namespace App\Http\Controllers\Api;

require_once __DIR__ . '/../../../../vendor/autoload.php';
//require_once 'C:\wamp64\www\laravel-flight-searching-demo\vendor\autoload.php';

use Amadeus\Amadeus;
use Amadeus\Exceptions\ResponseException;
use App\Http\Controllers\Controller;
use App\Http\Resources\AmadeusDestinationResource;
use App\Http\Resources\AmadeusFlightOfferResource;
use Illuminate\Http\Request;
use Monolog\Logger;

class AmadeusController extends Controller
{

    private Amadeus $client;

    public function __construct()
    {
        $this->client = Amadeus::builder(env('AMADEUS_CLIENT_ID'),env('AMADEUS_CLIENT_SECRET'))->build();
        $this->client->setSslCertificate(__DIR__ . '/../../../../certificate/cacert-2022-03-18.pem');
    }

    /**
     * @throws ResponseException
     */
    public function getDirectDestinations(Request $request): array
    {
        $destinations = $this->client->airport->directDestinations->get(
            array(
                "departureAirportCode" => $request->{'departureAirportCode'},
                "max" => $request->{'max'}
            )
        );

        return [
            "meta" => $destinations[0]->getResponse()->getBodyAsJsonObject()->{'meta'},
            "data" => AmadeusDestinationResource::collection($destinations)
        ];

    }

    /**
     * @throws ResponseException
     */
    public function getFlightOffers(Request $request): array
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

        return [
            "meta" => $flightOffers[0]->getResponse()->getBodyAsJsonObject()->{'meta'},
            "data" => AmadeusFlightOfferResource::collection($flightOffers)
        ];
    }
}
