<?php

namespace App\Http\Controllers\Api;

//require_once __DIR__ . '/../../../../vendor/autoload.php';

use Amadeus\Amadeus;
use App\Http\Controllers\Controller;
use Exception;

class AmadeusController extends Controller
{
    protected Amadeus $amadeus;
    private ?string $token = null;
    private ?int $expiresAt = null;

    /**
     * @throws Exception
     */
    public function __construct(Amadeus $amadeus)
    {
        $this->amadeus = $amadeus;
        $this->amadeus->setSslCertificate(__DIR__ . '/../../../../certificate/cacert-2022-03-18.pem');

        $this->amadeus->getAccessToken()->setAccessToken(cache('token'));
        $this->amadeus->getAccessToken()->setExpiresAt(cache('expires_at'));

        $this->token = $this->amadeus->getAccessToken()->getBearerToken();
        $this->expiresAt = $this->amadeus->getAccessToken()->getExpiresAt();

        $this->cacheToken();
    }

    /**
     * @throws Exception
     */
    private function cacheToken()
    {
        cache(['token' => $this->token]);
        cache(['expires_at' => $this->expiresAt]);
    }
}

