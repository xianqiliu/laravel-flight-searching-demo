<?php

namespace App\Http\Controllers\Api;

use Amadeus\Amadeus;
use App\Http\Controllers\Controller;
use Exception;

class AmadeusController extends Controller
{
    protected Amadeus $amadeus;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->amadeus = app(Amadeus::class);
    }
}

