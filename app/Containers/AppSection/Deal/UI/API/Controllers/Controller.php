<?php

namespace App\Containers\AppSection\Deal\UI\API\Controllers;

use Apiato\Core\Loaders\ViewsLoaderTrait;
use App\Containers\AppSection\Deal\Actions\GetCurrentDealsAction;
use App\Containers\AppSection\Deal\Actions\GetDealsByCounterpartyAction;
use App\Containers\AppSection\Deal\Actions\GetDealsToExportAction;
use App\Containers\AppSection\Deal\Actions\GetInterestRates;
use App\Containers\AppSection\Deal\Actions\GetLenderMissedDealsAction;
use App\Containers\AppSection\Deal\Actions\GetLenderSuccessRateAction;
use App\Containers\AppSection\Deal\Actions\GetLiveDealsAction;
use App\Containers\AppSection\Deal\Actions\GetLiveDealsFiltering;
use App\Containers\AppSection\Deal\Actions\GetLiveDealSorting;
use App\Containers\AppSection\Deal\Actions\GetQuotesAction;
use App\Containers\AppSection\Deal\Actions\SignContractAction;
use App\Containers\AppSection\Deal\Actions\UpdateDealAction;
use App\Containers\AppSection\Deal\Actions\UpdateDealOfferAction;
use App\Containers\AppSection\Deal\Actions\UploadAction;
use App\Containers\AppSection\Deal\UI\API\Requests\AdminGetDealsByCountryRequest;
use App\Containers\AppSection\Deal\UI\API\Requests\CreateDealRequest;
use App\Containers\AppSection\Deal\UI\API\Requests\ExportDealsRequest;
use App\Containers\AppSection\Deal\UI\API\Requests\GetDealsByCounterpartyRequest;
use App\Containers\AppSection\Deal\UI\API\Requests\GetInterestRatesRequest;
use App\Containers\AppSection\Deal\UI\API\Requests\GetLiveDealsRequest;
use App\Containers\AppSection\Deal\UI\API\Requests\MySuccessRateRequest;
use App\Containers\AppSection\Deal\UI\API\Requests\PatchOfferRequest;
use App\Containers\AppSection\Deal\UI\API\Requests\SubmitDealRequest;
use App\Containers\AppSection\Deal\UI\API\Requests\MyDealsRequest;
use App\Containers\AppSection\Deal\UI\API\Requests\GetDetailDealRequest;
use App\Containers\AppSection\Deal\UI\API\Requests\GetUserDealsRequest;
use App\Containers\AppSection\Deal\UI\API\Requests\ChangeDealStatusRequest;
use App\Containers\AppSection\Deal\UI\API\Requests\LenderAcceptTermsRequest;
use App\Containers\AppSection\Deal\UI\API\Requests\GetDealsRequest;
use App\Containers\AppSection\Deal\Actions\CreateDealAction;
use App\Containers\AppSection\Deal\Actions\SubmitDealAction;
use App\Containers\AppSection\Deal\Actions\GetUserDealsAction;
use App\Containers\AppSection\Deal\Actions\FindDealByIdAction;
use App\Containers\AppSection\Deal\Actions\ChangeDealStatusAction;
use App\Containers\AppSection\Deal\Actions\GetDealsAction;
use App\Containers\AppSection\Deal\Actions\LenderAcceptTermsAction;
use App\Containers\AppSection\Deal\UI\API\Requests\UploadRequest;
use App\Containers\AppSection\Deal\UI\API\Transformers\DealOfferTransformer;
use App\Containers\AppSection\Deal\UI\API\Transformers\LiveDealTransformer;
use App\Containers\AppSection\Deal\UI\API\Transformers\SummaryDealTransformer;
use App\Containers\AppSection\Deal\UI\API\Transformers\DetailDealTransformer;
use App\Containers\AppSection\Deal\UI\API\Transformers\DealTransformer;
use App\Containers\AppSection\Rate\Tasks\GetAllRatesTask;
use App\Containers\AppSection\UserProfile\Actions\GetDealsByCountryAction;
use App\Ship\Parents\Controllers\ApiController;
use App\Ship\Parents\Requests\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use App\Ship\Helpers as helpers;
use App\Containers\AppSection\System\Enums\Currency;

class Controller extends ApiController
{
    use ViewsLoaderTrait;

    public function exportDeals(ExportDealsRequest $request) {
        $deals = app(GetDealsToExportAction::class)->run($request);
        if ($request->type == 'missed' || $request->type == 'current') {
            $pdf = PDF::loadView('appSection@deal::Export.Templates.deals',
                ['deals' => $this->transform($deals, DealOfferTransformer::class)]);
        } else {
            $pdf = PDF::loadView('appSection@deal::Export.Templates.deals',
                ['deals' => $this->transform($deals, DealTransformer::class)]);
        }
        return $pdf->download('deals.pdf');
    }

    public function exportDealDetail(GetDetailDealRequest $request) {
        $deal = app(FindDealByIdAction::class)->run($request);

        if($deal) $deal = $this->transform($deal, DetailDealTransformer::class);

        $pdf = PDF::loadView('appSection@deal::Export.Templates.deal-detail',
            ['deal' => $deal['data']]);

        return $pdf->download('deal.pdf');

    }

    public function createDeal(CreateDealRequest $request): JsonResponse
    {
        $deal = app(CreateDealAction::class)->run($request);
        return new JsonResponse(
            [
                'id' => $deal->getHashedKey()
            ]
        );
    }

    public function UpdateDeal(SubmitDealRequest $request): JsonResponse
    {
        $deal = app(UpdateDealAction::class)->run($request);
        return new JsonResponse(
            [
                'id' => $deal->getHashedKey()
            ]
        );
    }

    public function SubmitDeal(SubmitDealRequest $request): JsonResponse
    {
        $deal = app(SubmitDealAction::class)->run($request);
        return new JsonResponse(
            [
                'id' => $deal->getHashedKey()
            ]
        );
    }

    public function MyDeals(MyDealsRequest $request)
    {
        $deals = app(GetUserDealsAction::class)->run($request, $request->user()->id);
        return $this->transform($deals, SummaryDealTransformer::class);
    }

    public function MySuccessRate(MySuccessRateRequest $request)
    {
        return app(GetLenderSuccessRateAction::class)->run($request->user()->id);
    }

    public function GetUserDeals(GetUserDealsRequest $request)
    {
        $deals = app(GetUserDealsAction::class)->run($request, $request->user_id);
        return $this->transform($deals, SummaryDealTransformer::class);
    }


    public function GetDetailDeal(GetDetailDealRequest $request)
    {
        $deal = app(FindDealByIdAction::class)->run($request);
        return $this->transform($deal, DetailDealTransformer::class);
    }

    public function ChangeDealStatus(ChangeDealStatusRequest $request)
    {
        app(ChangeDealStatusAction::class)->run($request);
        return $this->noContent();
    }

    public function SignContract(ChangeDealStatusRequest $request)
    {
        app(SignContractAction::class)->run($request);
        return $this->noContent();
    }

    public function GetDeals(GetDealsRequest $request)
    {
        $deals = app(GetDealsAction::class)->run($request);
        $user = \Auth::user();

        if ($user->isLender()) {
            return $this->transform($deals, DealOfferTransformer::class);
        }
        return $this->transform($deals, DealTransformer::class);
    }

    public function getQuotes(GetDealsRequest $request)
    {
        $quotes = app(GetQuotesAction::class)->run($request);

        return $this->transform($quotes, DealTransformer::class);
    }

    public function getLendersMissedDeals(GetDealsRequest $request): array
    {
        $deals = app(GetLenderMissedDealsAction::class)->run($request);
        return $this->transform($deals, DealOfferTransformer::class);
    }


    public function getCurrentDeals(GetDealsRequest $request): array
    {
        $deals = app(GetCurrentDealsAction::class)->run($request);
        return $this->transform($deals, DealOfferTransformer::class);
    }

    public function getLiveDeals(GetLiveDealsRequest $request)
    {
        $deals = app(GetLiveDealsAction::class)->run($request);
        $rates = app(GetAllRatesTask::class)->run();
        $totalAmount = 0;

        foreach ($deals as $row) {
            $row->currencyTo = $request->selected_currency ?: $row->currency;
            $row->contract_amount = helpers\exchangeRate($row->currency, $row->currencyTo, $row->contract_amount, $rates);

            if (!$request->selected_currency) {
                $totalAmount += helpers\exchangeRate($row->currency, Currency::getDescription(Currency::GBP), $row->contract_amount, $rates);
            } else {
                $totalAmount += $row->contract_amount;
            }
        }

        $data = $this->transform($deals, LiveDealTransformer::class);

        $data['totalAmount'] = number_format($totalAmount, 2);
        $data['sorting'] = [];
        $data['filtering'] = [];
        $user = \Auth::user();
        if ($user->hasAdminRole()) {
            $data['sorting'] = app(GetLiveDealSorting::class)->run();
            $data['filtering'] = app(GetLiveDealsFiltering::class)->run();
        }

        return $data;
    }

    public function upload(UploadRequest $request)
    {
        app(UploadAction::class)->run($request);
        return $this->noContent();
    }

    public function patchOffer(PatchOfferRequest $request)
    {
        app(UpdateDealOfferAction::class)->run($request);
        return $this->noContent();
    }

    public function LenderAcceptTerms(LenderAcceptTermsRequest $request)
    {
        app(LenderAcceptTermsAction::class)->run($request);
        return $this->noContent();
    }

    public function GetDealsByCounterparty(GetDealsByCounterpartyRequest $request): JsonResponse
    {
        $result = app(GetDealsByCounterpartyAction::class)->run($request);
        return new JsonResponse($result);
    }

    public function getDealsByCountry(AdminGetDealsByCountryRequest $request): JsonResponse
    {
        $data = app(GetDealsByCountryAction::class)->run();
        return new JsonResponse($data);
    }

    public function GetInterestRates(GetInterestRatesRequest $request): JsonResponse
    {
        $rates = app(GetInterestRates::class)->run($request->type, $request->entity_id);
        return new JsonResponse($rates);
    }
}
