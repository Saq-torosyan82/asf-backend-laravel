<?php

namespace App\Containers\AppSection\Financial\UI\WEB\Controllers;

use App\Containers\AppSection\Financial\UI\WEB\Requests\CreateFinancialRequest;
use App\Containers\AppSection\Financial\UI\WEB\Requests\DeleteFinancialRequest;
use App\Containers\AppSection\Financial\UI\WEB\Requests\GetAllFinancialsRequest;
use App\Containers\AppSection\Financial\UI\WEB\Requests\FindFinancialByIdRequest;
use App\Containers\AppSection\Financial\UI\WEB\Requests\UpdateFinancialRequest;
use App\Containers\AppSection\Financial\UI\WEB\Requests\StoreFinancialRequest;
use App\Containers\AppSection\Financial\UI\WEB\Requests\EditFinancialRequest;
use App\Containers\AppSection\Financial\Actions\CreateFinancialAction;
use App\Containers\AppSection\Financial\Actions\FindFinancialByIdAction;
use App\Containers\AppSection\Financial\Actions\GetAllFinancialsAction;
use App\Containers\AppSection\Financial\Actions\UpdateFinancialAction;
use App\Containers\AppSection\Financial\Actions\DeleteFinancialAction;
use App\Ship\Parents\Controllers\WebController;

class Controller extends WebController
{
}
