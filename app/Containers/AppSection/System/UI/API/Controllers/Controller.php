<?php

namespace App\Containers\AppSection\System\UI\API\Controllers;


use App\Containers\AppSection\System\Actions\CreateSportBrandAction;
use App\Containers\AppSection\System\Actions\CreateSportClubAction;
use App\Containers\AppSection\System\Actions\CreateSportLeagueAction;
use App\Containers\AppSection\System\Actions\CreateSportSponsorAction;
use App\Containers\AppSection\System\Actions\GetAllCountriesAction;
use App\Containers\AppSection\System\Actions\GetAllLenderCriteriaAction;
use App\Containers\AppSection\System\Actions\GetAllSportCountriesAction;
use App\Containers\AppSection\System\Actions\GetAllSportsAction;
use App\Containers\AppSection\System\Actions\GetAllBorrowerTypesAction;
use App\Containers\AppSection\System\Actions\GetAllSportLeaguesAction;
use App\Containers\AppSection\System\Actions\GetAllSportClubsAction;
use App\Containers\AppSection\System\Actions\GetAllClubCountriesAction;
use App\Containers\AppSection\System\Actions\GetAllTvRightsHoldersAction;
use App\Containers\AppSection\System\Actions\GetAllSportBrandsAction;
use App\Containers\AppSection\System\Actions\GetAllSportSponsorsAction;
use App\Containers\AppSection\System\Actions\GetSportNewsAction;
use App\Containers\AppSection\System\Actions\GetSportNewsDashboardAction;
use App\Containers\AppSection\System\Tasks\GetSportBrandByNameTask;
use App\Containers\AppSection\System\Tasks\GetSportClubByNameTask;
use App\Containers\AppSection\System\Tasks\GetSportLeagueByNameTask;
use App\Containers\AppSection\System\Tasks\GetSportSponsorByNameTask;
use App\Containers\AppSection\System\UI\API\Requests\CreateSportBrandSponsorRequest;
use App\Containers\AppSection\System\UI\API\Requests\CreateSportClubRequest;
use App\Containers\AppSection\System\UI\API\Requests\CreateSportLeaguesRequest;
use App\Containers\AppSection\System\UI\API\Requests\GetAllLenderCriteriaRequest;
use App\Containers\AppSection\System\UI\API\Requests\GetAllSportCountriesRequest;
use App\Containers\AppSection\System\UI\API\Requests\GetAllSportsRequest;
use App\Containers\AppSection\System\UI\API\Requests\GetAllBorrowerTypesRequest;
use App\Containers\AppSection\System\UI\API\Requests\GetAllCountriesRequest;
use App\Containers\AppSection\System\UI\API\Requests\GetAllSportLeaguesRequest;
use App\Containers\AppSection\System\UI\API\Requests\GetAllSportClubsRequest;
use App\Containers\AppSection\System\UI\API\Requests\GetAllTvRightsHoldersRequest;
use App\Containers\AppSection\System\UI\API\Requests\GetAllSportBrandsRequest;
use App\Containers\AppSection\System\UI\API\Requests\GetAllSportSponsorsRequest;
use App\Containers\AppSection\System\UI\API\Requests\GetSportNewsDashboardRequest;
use App\Containers\AppSection\System\UI\API\Requests\GetSportNewsRequest;
use App\Containers\AppSection\System\UI\API\Transformers\CountryTransformer;
use App\Containers\AppSection\System\UI\API\Transformers\SportTransformer;
use App\Containers\AppSection\System\UI\API\Transformers\BorrowerTypeTransformer;
use App\Containers\AppSection\System\UI\API\Transformers\SportLeagueTransformer;
use App\Containers\AppSection\System\UI\API\Transformers\SportClubTransformer;
use App\Containers\AppSection\System\UI\API\Transformers\TvRightsHolderTransformer;
use App\Containers\AppSection\System\UI\API\Transformers\SportBrandTransformer;
use App\Containers\AppSection\System\UI\API\Transformers\SportSponsorTransformer;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use voku\helper\ASCII;

class Controller extends ApiController
{
    public function getAllSports(GetAllSportsRequest $request): array
    {
        $sports = app(GetAllSportsAction::class)->run($request);
        return $this->transform($sports, SportTransformer::class);
    }

    public function getAllCountries(GetAllCountriesRequest $request): array
    {
        $countries = app(GetAllCountriesAction::class)->run($request);
        return $this->transform($countries, CountryTransformer::class);
    }

    public function GetAllBorrowerTypes(GetAllBorrowerTypesRequest $request): array
    {
        $borrower_types = app(GetAllBorrowerTypesAction::class)->run($request);
        return $this->transform($borrower_types, BorrowerTypeTransformer::class);
    }

    public function GetAllSportLeagues(GetAllSportLeaguesRequest $request): array {
        $sport_leagues = app(GetAllSportLeaguesAction::class)->run($request);
        return $this->transform($sport_leagues, SportLeagueTransformer::class);
    }

    public function GetAllSportClubs(GetAllSportClubsRequest $request): array {
        $sport_clubs = app(GetAllSportClubsAction::class)->run($request);
        return $this->transform($sport_clubs, SportClubTransformer::class);
    }

    public function GetAllClubCountries(GetAllCountriesRequest $request): array {
        $countries = app(GetAllClubCountriesAction::class)->run($request);
        return $this->transform($countries, CountryTransformer::class);
    }

    public function GetAllTvRightsHolders(GetAllTvRightsHoldersRequest $request): array {
        $countries = app(GetAllTvRightsHoldersAction::class)->run($request);
        return $this->transform($countries, TvRightsHolderTransformer::class);
    }

    public function GetAllSportBrands(GetAllSportBrandsRequest $request): array {
        $countries = app(GetAllSportBrandsAction::class)->run($request);
        return $this->transform($countries, SportBrandTransformer::class);
    }

    public function GetAllSportSponsors(GetAllSportSponsorsRequest $request): array
    {
        $countries = app(GetAllSportSponsorsAction::class)->run($request);
        return $this->transform($countries, SportSponsorTransformer::class);
    }

    public function getAllLenderCriteria(GetAllLenderCriteriaRequest $request): JsonResponse
    {
        $lenderCriteria = app(GetAllLenderCriteriaAction::class)->run($request);
        return $this->json($lenderCriteria);
    }

    public function GetAllSportCountries(GetAllSportCountriesRequest $request): JsonResponse {
        $sport_countries = app(GetAllSportCountriesAction::class)->run($request);
        return $this->json($sport_countries);
    }

    public function GetSportNews(GetSportNewsRequest $request): JsonResponse {
        $sport_news = app(GetSportNewsAction::class)->run($request);
        return $this->json($sport_news);
    }

    public function GetSportNewsDashboard(GetSportNewsDashboardRequest $request): JsonResponse {
        $sport_news = app(GetSportNewsDashboardAction::class)->run($request);
        return $this->json($sport_news);
    }

    public function CreateSportBrand(CreateSportBrandSponsorRequest $request) {
        $sportBrand = app(GetSportBrandByNameTask::class)->run($request->name);
        if($sportBrand) {
            return $this->json([], 409);
        }

        $sportBrand = app(CreateSportBrandAction::class)->run($request);

        return $this->transform($sportBrand, SportBrandTransformer::class);
    }

    public function CreateSportSponsor(CreateSportBrandSponsorRequest $request) {
        $sportSponsor = app(GetSportSponsorByNameTask::class)->run($request->name);
        if($sportSponsor) {
            return $this->json([], 409);
        }

        $sportSponsor = app(CreateSportSponsorAction::class)->run($request);

        return $this->transform($sportSponsor, SportSponsorTransformer::class);
    }

    public function CreateSportClub(CreateSportClubRequest $request) {
        $sportClub = app(GetSportClubByNameTask::class)->run($request->name);
        if($sportClub) {
            return $this->json([], 409);
        }

        $sportClub = app(CreateSportClubAction::class)->run($request);

        return $this->transform($sportClub, SportClubTransformer::class);
    }

    public function CreateSportLeagues(CreateSportLeaguesRequest $request) {
        $sportLeague = app(GetSportLeagueByNameTask::class)->run($request->name);
        if($sportLeague) {
            return $this->json([], 409);
        }
        $sportLeague = app(CreateSportLeagueAction::class)->run($request);

        return $this->transform($sportLeague, SportLeagueTransformer::class);
    }
}
