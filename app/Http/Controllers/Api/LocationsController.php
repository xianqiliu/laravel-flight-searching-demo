<?php

namespace App\Http\Controllers\Api;

use Amadeus\Exceptions\ResponseException;
use App\Http\Resources\LocationResource;
use Illuminate\Http\Request;
use SplFixedArray;

class LocationsController extends AmadeusController
{
    /**
     * @throws ResponseException
     */
    public function getLocations(Request $request): array
    {
        $baseLink = "/api/locations?subType=CITY&keyword=PAR&page[offset]=";
        $pageLimit = 7;

        $locations = $this->amadeus->getReferenceData()->getLocations()->get(
            array(
                "subType" => $request['subType'],
                "keyword" => $request['keyword'],
                "countryCode" => $request['countryCode'],
                "page[limit]" => $pageLimit,
                "page[offset]" => $request['page']['offset']
            )
        );

        $meta = empty($locations) ? null : $locations[0]->getResponse()->getBodyAsJsonObject()->{'meta'};

        $links = $meta->{'links'};
        foreach ($links as $key => $url )
        {
            $url = explode('?', $url);
            $newUrl = "/api/locations?" . $url[ count($url) - 1 ];
            $links->$key = $newUrl;
        }

        $pageCount = ($meta->{'count'} < $pageLimit) ? 1 : ceil($meta->{'count'} / $pageLimit);
        $meta->{'pageCount'} = $pageCount;

        $linksForEachPage = new SplFixedArray($pageCount);
        foreach ($linksForEachPage as $key => $value) {
            $linksForEachPage[$key] = $baseLink.($pageLimit*$key);
        }
        $meta->{'linksForEachPage'} = $linksForEachPage;

        return [
            "meta" => $meta,
            "data" => LocationResource::collection($locations)
        ];
    }
}
