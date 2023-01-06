<?php

namespace App\Containers\AppSection\Communication\Actions;

use App\Containers\AppSection\Communication\Enums\QuestionType;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class GetQuestionTypesAction extends Action
{
    public function run(Request $request)
    {
        return QuestionType::getAllQuestions();
    }
}
