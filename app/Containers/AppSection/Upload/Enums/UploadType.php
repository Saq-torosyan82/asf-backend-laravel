<?php

namespace App\Containers\AppSection\Upload\Enums;

use BenSampo\Enum\Enum;

final class UploadType extends Enum
{
    // TYPE
    const AVATAR = 'UserAvatar';
    const DOCUMENT = 'UserDocuments';
    const CONSENT = 'CounterpartyConsent';
    const TERM_SHEET = 'DealTermSheet';
    const CONTRACT = 'DealContract';
    const CREDIT_ANALYSIS = 'CreditAnalysis';
    const BORROWER_SIGNATURE = 'BorrowerSignature';
    const LENDER_SIGNATURE = 'LenderSignature';
    const FINANCIAL = 'Financial';
    const AGENT_AVATAR = 'AgentAvatar';
    const COMMUNICATION = 'Communication';
    const SPORT_BRANDS = 'SportBrands';
    const SPORT_SPONSORS = 'SportSponsors';
    const SPORT_CLUBS = 'SportClubs';
    const SPORT_LEAGUES = 'SportLeagues';
    const ASSOCIATION_LOGOS = 'AssociationLogos';
    const CONFEDERATION_LOGOS = 'ConfederationLogos';


    const DETAILS = [
        self::AVATAR => [
            'storage' => 'avatars',
            'privacy' => UploadPrivacy::PUBLIC
        ],
        self::SPORT_BRANDS => [
            'storage' => 'sport-brands',
            'privacy' => UploadPrivacy::PUBLIC
        ],
        self::SPORT_SPONSORS => [
            'storage' => 'sport-sponsors',
            'privacy' => UploadPrivacy::PUBLIC
        ],
        self::SPORT_CLUBS => [
            'storage' => 'sport-clubs',
            'privacy' => UploadPrivacy::PUBLIC
        ],
        self::ASSOCIATION_LOGOS => [
            'storage' => 'association-logos',
            'privacy' => UploadPrivacy::PUBLIC
        ],
        self::CONFEDERATION_LOGOS => [
            'storage' => 'confederation-logos',
            'privacy' => UploadPrivacy::PUBLIC
        ],
        self::SPORT_LEAGUES => [
            'storage' => 'sport-leagues',
            'privacy' => UploadPrivacy::PUBLIC
        ],
        self::AGENT_AVATAR => [
            'storage' => 'agents',
            'privacy' => UploadPrivacy::PUBLIC
        ],
        self::DOCUMENT => [
            'storage' => 'documents',
            'privacy' => UploadPrivacy::PRIVATE
        ],
        self::CONSENT => [
            'storage' => 'consents',
            'privacy' => UploadPrivacy::PRIVATE
        ],
        self::TERM_SHEET => [
            'storage' => 'term-sheets',
            'privacy' => UploadPrivacy::PRIVATE
        ],
        self::CONTRACT => [
            'storage' => 'contract',
            'privacy' => UploadPrivacy::PRIVATE
        ],
        self::CREDIT_ANALYSIS => [
            'storage' => 'credit-analysis',
            'privacy' => UploadPrivacy::PRIVATE
        ],
        self::BORROWER_SIGNATURE => [
            'storage' => 'signatures',
            'privacy' => UploadPrivacy::PRIVATE
        ],
        self::LENDER_SIGNATURE => [
            'storage' => 'signatures',
            'privacy' => UploadPrivacy::PRIVATE
        ],
        self::FINANCIAL => [
            'storage' => 'financials',
            'privacy' => UploadPrivacy::PRIVATE
        ],
        self::COMMUNICATION => [
            'storage' => 'communications',
            'privacy' => UploadPrivacy::PRIVATE
        ],
    ];

    const DEFAULT_PATH = 'general';


    public static function GetPathByUploadType(string $uploadType, ?int $entityId)
    {
        if (!isset(self::DETAILS[$uploadType])) {
            return self::DEFAULT_PATH;
        }

        $path = self::DETAILS[$uploadType]['storage'];

        if ($entityId === null) {
            $entityId = 0;
        }

        switch ($uploadType) {
            case self::DOCUMENT:
            case self::AVATAR:
            case self::AGENT_AVATAR:
            case self::CONSENT:
            case self::TERM_SHEET:
            case self::CONTRACT:
            case self::CREDIT_ANALYSIS:
            case self::BORROWER_SIGNATURE:
            case self::FINANCIAL:
            case self::COMMUNICATION:
            case self::LENDER_SIGNATURE:
                return $path . '/' . $entityId;
            case self::SPORT_BRANDS:
            case self::SPORT_SPONSORS:
            case self::SPORT_CLUBS:
            case self::SPORT_LEAGUES:
            case self::CONFEDERATION_LOGOS:
                return '/public/logo/'.$path;
        }

        return $path;
    }
}
