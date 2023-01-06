<?php

/**
 * @apiGroup           Upload
 * @apiName            createUpload
 *
 * @api                {POST} /v1/uploads Upload file
 * @apiDescription     EUpload file
 *
 * @apiVersion         1.0.0
 * @apiPermission      hasAccess
 *
 * @apiParam           {File}  file
 * @apiParam           {String}  user_id
 * @apiParam           {String}  upload_type Possible types : (UserAvatar, UserDocuments, CounterpartyConsent, DealTermSheet, DealContract, CreditAnalysis, BorrowerSignature, LenderSignature, Financial, AgentAvatar, Communication, SportBrands, SportSponsors, SportClubs, SportLeagues, AssociationLogos, ConfederationLogos)
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

Route::post('upload', [Controller::class, 'createUpload'])
    ->name('api_upload_create_upload')
    ->middleware(['auth:api']);

