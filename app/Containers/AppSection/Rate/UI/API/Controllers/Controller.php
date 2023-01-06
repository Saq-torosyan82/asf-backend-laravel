<?php

namespace App\Containers\AppSection\Rate\UI\API\Controllers;

use App\Containers\AppSection\Rate\Actions\GetAllRatesAction;
use App\Containers\AppSection\Rate\UI\API\Requests\GetAllRatesRequest;
use App\Containers\AppSection\Rate\UI\API\Transformers\RateTransformer;
use App\Ship\Parents\Controllers\ApiController;

class Controller extends ApiController
{
    /**
     * @param GetAllRatesRequest $request
     * @return array
     * @throws \Apiato\Core\Exceptions\CoreInternalErrorException
     * @throws \Apiato\Core\Exceptions\InvalidTransformerException
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function getAllRates(getAllRatesRequest $request): array
    {
        return app(GetAllRatesAction::class)->run($request);
    }

}
