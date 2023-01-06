<?php

namespace App\Containers\AppSection\UserProfile\Tasks;

use App\Ship\Exceptions\ConflictException;
use App\Ship\Parents\Tasks\Task;

class ValidateOnBoardingDataTask extends Task
{
    public function run(array &$input, $groupedKeysToInsert)
    {
        foreach($groupedKeysToInsert as $group => $keysToInsert) {
            if(!isset($input[$group])) {
                throw new ConflictException('Missing ' . $group . ' group from request');
            }
            $inputKeys = $input[$group];
            foreach($keysToInsert as $keyToInsert) {
                if(!in_array($keyToInsert, array_keys($inputKeys)) || $inputKeys[$keyToInsert] === '' || is_null($inputKeys[$keyToInsert])){
                    throw new ConflictException('Missing ' . $keyToInsert . ' from group ' . $group);
                }

                if(is_array($inputKeys[$keyToInsert])) {
                    $filteredValues = [];
                    foreach($inputKeys[$keyToInsert] as $key => $value) {
                        if(is_null($value) || $value === '' || $value == []) {
                            unset($inputKeys[$keyToInsert][$key]);
                        } else {
                            $filteredValues[] = $value;
                        }
                    }
    
                    $input[$group][$keyToInsert] = $filteredValues;
                    if(count($filteredValues) === 0) throw new ConflictException('Missing ' . $keyToInsert);
                }
            }
        }
    }
}
