<?php

/**
 * @apiGroup           Deal
 * @apiName            SubmitDeal
 *
 * @api                {POST} /v1/deal/:id/submit Submit the deal
 * @apiDescription     Submit the deal
 *
 * @apiVersion         1.0.0
 * @apiPermission      hasAccess
 *
 * @apiParam           {String}  id Deal id
 *
 * @apiParam           {String}  deal_type
 * @apiParam           {String}  contract_type
 * @apiParam           {String}  currency
 * @apiParam           {Float}  total
 * @apiParam           {Float}  upfrontValue
 * @apiParam           {String}   tvHolder
 * @apiParam           {String}  sponsorsOrBrandsIdentifier
 * @apiParam           {String}    sponsorOrBrand
 * @apiParam           {String}  league
 * @apiParam           {String}  club
 * @apiParam           {String}  contract_type
 * @apiParam           {String}  user_type
 * @apiParam           {String}  athlete
 * @apiParam           {String}  club_type
 * @apiParam           {Date}  firstInstalment
 * @apiParam           {String}  frequency
 * @apiParam           {Int}  numberOfInstalments
 * @apiParam           {Date}  fundingDate
 * @apiParam           {String}  legalCost
 * @apiParam           {String}  insuranceExpense
 * @apiParam           {String}  costs
 * @apiParam           {String}  paymentEntries
 * @apiParam           {String}  interestRate
 * @apiParam           {Float}  grossTotal
 * @apiParam           {Float}  totalOfDeal
 * @apiParam           {String}  [informedIntention]
 * @apiParam           {String}  [confirmUsageOfDocuments]
 * @apiParam           {String}  [shownToFinancier]
 * @apiParam           {String}  [shownToFinancier]
 * @apiParam           {String}  [sellerAgreement]
 * @apiParam           {String}  [contacts]
 * @apiParam           {String}  [financiers]
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
{
  data: {
     id: ''
 }
}
 */

use App\Containers\AppSection\Deal\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::post('deals/submit', [Controller::class, 'SubmitDeal'])
    ->name('api_deals_submit_deal')
    ->middleware(['auth:api']);

