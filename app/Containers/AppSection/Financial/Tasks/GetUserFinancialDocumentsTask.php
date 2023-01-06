<?php

namespace App\Containers\AppSection\Financial\Tasks;

use App\Containers\AppSection\Financial\Data\Repositories\FinancialDocumentRepository;
use App\Containers\AppSection\UserProfile\Data\Repositories\UserProfileRepository;
use App\Containers\AppSection\UserProfile\Enums\Group;
use App\Containers\AppSection\UserProfile\Enums\Key;
use App\Ship\Parents\Tasks\Task;

class GetUserFinancialDocumentsTask extends Task
{
    protected FinancialDocumentRepository $repository;
    protected UserProfileRepository $userProfileRepository;

    public function __construct(FinancialDocumentRepository $repository,
                                UserProfileRepository $userProfileRepository)
    {
        $this->repository = $repository;
        $this->userProfileRepository = $userProfileRepository;
    }

    public function run($user_id, $club_id, $section_id = null)
    {
        if(!$club_id) {
            $club = $this->userProfileRepository->where('group', Group::PROFESSIONAL)
                ->where('key', Key::CLUB)
                ->where('user_id', $user_id)
                ->first();

            if(is_null($club)){
                return [];
            }

            $club_id = $club->value;
        }

        $actual =  app(GetActualFinancialTask::class)->run($club_id);
        $docs =[];
        if (!empty($actual)) {
            $docs = $this->repository->select('financial_documents.id','financial_documents.status','fs.label','uploads.uuid', 'financial_documents.created_at','uploads.user_id', 'uploads.init_file_name', 'financial_documents.upload_id', 'financial_documents.section_id')
                ->leftJoin('financial_sections as fs', 'financial_documents.section_id', '=','fs.id')
                ->leftJoin('uploads', 'uploads.id', '=', 'financial_documents.upload_id')
                ->when($section_id != null, function($query) use($section_id){
                    return $query->where('financial_documents.section_id', $section_id);
                })
                ->where('financial_documents.financial_id', $actual->id)
                ->orderBy('financial_documents.created_at', 'DESC')->get();
        }
        return $docs;

    }
}
