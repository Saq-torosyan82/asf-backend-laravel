<?php

/**
 * @apiGroup           Upload
 * @apiName            UploadDocument
 *
 * @api                {POST} /v1/me/documents Upload document
 * @apiDescription     Upload document
 *
 * @apiVersion         1.0.0
 * @apiPermission      hasAccess
 *
 * @apiParam           {String}  deal_id
 * @apiParam           {File}  file
 * @apiParam           {String}  document_type Possible types : (UserAvatar, UserDocuments, CounterpartyConsent, DealTermSheet, DealContract, CreditAnalysis, BorrowerSignature, LenderSignature, Financial, AgentAvatar, Communication, SportBrands, SportSponsors, SportClubs, SportLeagues, AssociationLogos, ConfederationLogos)
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
{
  data:{
    id: ''
 }
}
 */

use App\Containers\AppSection\Upload\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::post('me/documents', [Controller::class, 'UploadDocument'])
    ->name('api_upload_upload_document')
    ->middleware(['auth:api']);

