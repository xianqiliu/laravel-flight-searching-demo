<?php

namespace App\Http\Controllers\Api;

//require_once __DIR__ . '/../../../../vendor/autoload.php';

use Amadeus\Amadeus;
use App\Http\Controllers\Controller;
use Exception;

class AmadeusController extends Controller
{
    protected Amadeus $amadeus;
    private ?string $bearerToken;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->amadeus = app(Amadeus::class);
        $this->amadeus->getClient()->setSslCertificate(__DIR__ . '/../../../../certificate/cacert-2022-03-18.pem');

        $this->bearerToken = cache('bearer_token');
        if ($this->bearerToken) {
            $this->amadeus->getClient()->getAccessToken()->setBearerToken($this->bearerToken);
        } else {
            $this->bearerToken = $this->amadeus->getClient()->getAccessToken()->getBearerToken();
            $this->amadeus->getClient()->getAccessToken()->setBearerToken($this->bearerToken);
            $this->cacheToken();
        }

        //var_dump($this->bearerToken);
    }

    /**
     * @throws Exception
     */
    private function cacheToken()
    {
        cache(['bearer_token' => $this->bearerToken], now()->addSeconds(1799));
    }
}

