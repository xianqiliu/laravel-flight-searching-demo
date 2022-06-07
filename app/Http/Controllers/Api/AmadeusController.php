<?php

namespace App\Http\Controllers\Api;

//require_once __DIR__ . '/../../../../vendor/autoload.php';

use Amadeus\Amadeus;
use App\Http\Controllers\Controller;
use Exception;

class AmadeusController extends Controller
{
    protected Amadeus $amadeus;
    private ?string $bearerToken = null;
    private ?int $expiresAt = null;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->amadeus = app(Amadeus::class);
        $this->amadeus->client->setSslCertificate(__DIR__ . '/../../../../certificate/cacert-2022-03-18.pem');

        $this->amadeus->client->getAccessToken()->setBearerToken(cache('bearer_token'));
        $this->amadeus->client->getAccessToken()->setExpiresAt(cache('expires_at'));

        $this->bearerToken = $this->amadeus->client->getAccessToken()->getBearerToken();
        $this->expiresAt = $this->amadeus->client->getAccessToken()->getExpiresAt();

        $this->cacheToken();
    }

    /**
     * @throws Exception
     */
    private function cacheToken()
    {
        cache(['bearer_token' => $this->bearerToken]);
        cache(['expires_at' => $this->expiresAt]);
    }
}

