<?php

namespace App\Containers\AppSection\Deal\Actions;

use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Deal\Enums\DealStatus;
use App\Containers\AppSection\Deal\Tasks\GetAllDealsTask;
use App\Containers\AppSection\System\Enums\Currency;
use App\Ship\Parents\Actions\SubAction;

class GetLiveDealsFiltering extends SubAction
{
    use HashIdTrait;

    private $counterparties = [];
    private $countries = [];
    private $sports = [];
    private $borrowers = [];

    public function run()
    {
        $deals = app(GetAllDealsTask::class)->run();
        foreach ($deals as $row) {

            // set countries
            if ($row->country_id && !isset($this->countries[$row->country_id])) {
                $this->countries[$row->country_id] = $row->country->name;
            }

            // set sport
            if ($row->sport_id && !isset($this->sports[$row->sport_id])) {
                $this->sports[$row->sport_id] = $row->sport->name;
            }

            // set counterparty
            if ($row->counterparty && !isset($this->counterparties[$row->counterparty])) {
                $this->counterparties[$row->counterparty] = $row->counterparty;
            }

            // set borrower
            if (!isset($this->borrowers[$row->user_id])) {
                $this->borrowers[$row->user_id] = $row->user->first_name . ' ' . $row->user->last_name;
            }
        }

        return [
            $this->buildCountryFilter(),
            $this->buidDealTypeFilter(),
            $this->buildSportFilter(),
            $this->buildBorrowerFilter(),
            $this->buildCounterpartyFilter(),
            $this->buildStatusFilter(),
            $this->buildCurrencyFilter(),
        ];
    }

    /**
     * @return array
     */
    protected function buildCounterpartyFilter()
    {
        $options = [];
        $options[] = [
            'text' => 'All',
            'value' => '',
        ];
        foreach ($this->counterparties as $val) {
            $options[] = [
                'text' => $val,
                'value' => $val,
            ];
        }

        return [

            'label' => 'Obligor risk',
            'key' => 'counterparty',
            'options' => $options
        ];
    }

    /**
     * @return array
     */
    protected function buildStatusFilter()
    {
        $statuses = DealStatus::asSelectArray();
        $options = [];
        $options[] = [
            'text' => 'All',
            'value' => '',
        ];
        foreach ($statuses as $k => $v) {
            $options[] = [
                'text' => $v,
                'value' => $k,
            ];
        }

        return [

            'label' => 'Status',
            'key' => 'status',
            'options' => $options
        ];
    }

    protected function buildCurrencyFilter(): array
    {
        $options[] = [
            'text' => 'All',
            'value' => '',
        ];

        foreach (Currency::getAllCurrencies() as $currency) {
            $options[] = $currency;
        }

        return [
            'label' => 'Currency',
            'key' => 'currency',
            'options' => $options
        ];
    }

    /**
     * @return array
     */
    protected function buidDealTypeFilter()
    {
        return [
            'label' => 'Deal type',
            'key' => 'deal_type',
            'options' => [
                [
                    'text' => 'All',
                    'value' => '',
                ],
                [
                    'text' => 'Live',
                    'value' => 'live',
                ],
                [
                    'text' => 'Future',
                    'value' => 'future',
                ]
            ]
        ];
    }

    /**
     * @return array
     */
    protected function buildBorrowerFilter()
    {
        $options = [];
        $options[] = [
            'text' => 'All',
            'value' => '',
        ];
        foreach ($this->borrowers as $key => $val) {
            $options[] = [
                'text' => $val,
                'value' => $this->encode($key)
            ];
        }

        return [
            'label' => 'Borrower',
            'key' => 'user_id',
            'options' => $options
        ];
    }

    /**
     * @return array
     */
    protected function buildSportFilter()
    {
        $options = [];
        $options[] = [
            'text' => 'All',
            'value' => '',
        ];
        foreach ($this->sports as $key => $val) {
            $options[] = [
                'text' => $val,
                'value' => $this->encode($key)
            ];
        }

        return [
            'label' => 'Sport',
            'key' => 'sport_id',
            'options' => $options
        ];
    }

    /**
     * @return array
     */
    protected function buildCountryFilter()
    {
        $options = [];
        $options[] = [
            'text' => 'All',
            'value' => '',
        ];
        foreach ($this->countries as $key => $val) {
            $options[] = [
                'text' => $val,
                'value' => $this->encode($key)
            ];
        }

        return [
            'label' => 'Country',
            'key' => 'country_id',
            'options' => $options
        ];
    }
}
