<?php

/**
 * @apiGroup           Upload
 * @apiName            UploadUserDocument
 *
 * @api                {POST} /v1/users/:user_id/documents Upload user document
 * @apiDescription     Upload user document
 *
 * @apiVersion         1.0.0
 * @apiPermission      hasAccess
 *
 * @apiParam           {String}  user_id User id
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

Route::post('users/{user_id}/documents', [Controller::class, 'UploadUserDocument'])
    ->name('api_upload_upload_user_document')
    ->middleware(['auth:api']);

