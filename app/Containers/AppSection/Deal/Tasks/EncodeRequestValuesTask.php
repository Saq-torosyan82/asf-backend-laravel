<?php

namespace App\Containers\AppSection\Deal\Tasks;

use Apiato\Core\Traits\HashIdTrait;
use App\Ship\Parents\Tasks\Task;
use Carbon\Carbon;

class EncodeRequestValuesTask extends Task
{
    use HashIdTrait;

    public function run(array &$data, string $element, array $keys, $keys_required = true): bool
    {
        $is_multiple = false;
        if (count($keys)) {
            $is_multiple = true;
        }

        if (!isset($data[$element]) || !$data[$element]) {
            return false;
        }

        if (!$is_multiple) {
            $data[$element] = $this->encode($data[$element]);
            return true;
        }

        if (!is_array($data[$element])) {
            if (!$keys_required) {
                $data[$element] = $this->encode($data[$element]);
                return true;
            }

            return false;
        }

        foreach ($keys as $key) {
            if (isset($data[$element][$key]) && $data[$element][$key]) {
                $data[$element][$key] = $this->encode($data[$element][$key]);
            }
        }

        return true;
    }
}
