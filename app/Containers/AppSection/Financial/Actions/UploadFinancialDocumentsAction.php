<?php

namespace App\Containers\AppSection\Financial\Actions;

use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Upload\Actions\UploadFileSubAction;
use App\Containers\AppSection\Upload\Enums\UploadType;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class UploadFinancialDocumentsAction extends Action
{
    use HashIdTrait;
    public function run(Request $request): array
    {
        $files = $request->file('files');
        $docsIds = [];
        if ($files) {
            $files = !is_array($files) ? [$files] : $files;
            foreach ($files as $file) {
                $upload = app(UploadFileSubAction::class)->run($file, UploadType::FINANCIAL, $request->user()->id);
                $docsIds[] = $upload->getHashedKey();
            }
        }
        return $docsIds;
    }
}
