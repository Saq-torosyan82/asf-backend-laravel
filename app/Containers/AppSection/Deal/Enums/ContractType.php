<?php

namespace App\Containers\AppSection\Deal\Enums;

use App\Containers\AppSection\Authorization\Enums\PermissionType;
use App\Containers\AppSection\System\Enums\BorrowerType;
use BenSampo\Enum\Enum;

final class ContractType extends Enum
{
    const PLAYER_TRANSFER = 'player_transfer';
    const ENDORSEMENT = 'endorsement';
    const MEDIA_RIGHTS = 'media_rights';
    const PLAYER_ADVANCE = 'player_advance';
    const AGENT_FEES = 'agent_fees';

    public static function getDescription($value): string
    {
        switch ($value) {
            case self::PLAYER_ADVANCE:
                return 'Player Contract Advance';
        }

        return parent::getDescription($value);
    }

    public static function isPlayerTransfer($type)
    {
        $map = [
            self::PLAYER_TRANSFER => 1,
        ];

        return isset($map[$type]);
    }

    public static function getBorrowerAvailableContracts($type)
    {
        $map = [
            BorrowerType::CORPORATE => [
                self::PLAYER_TRANSFER => [],
                self::ENDORSEMENT => [],
                self::MEDIA_RIGHTS => [],
            ],
            BorrowerType::AGENT => [
                self::AGENT_FEES => [],
            ],
            BorrowerType::ATHLETE => [
                self::PLAYER_ADVANCE => [],
                self::ENDORSEMENT => []
            ]
        ];

        return isset($map[$type]) ? $map[$type] : [];
    }
    public static function getCriteriaDealType($value): string
    {
        switch ($value) {
            case self::PLAYER_TRANSFER:
                return 'Player Transfer';
            case self::ENDORSEMENT:
                return 'Endorsement Deals';
            case self::MEDIA_RIGHTS:
                return 'TV/Media Rights';
            case self::PLAYER_ADVANCE:
                return 'Players Contracts';
            case self::AGENT_FEES:
                return 'Agent Fees';
        }
        return parent::getDescription($value);
    }
}
