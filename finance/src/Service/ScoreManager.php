<?php

namespace App\Service;

use App\Entity\User;

class ScoreManager
{
    public const MEGAFON_CODE = 928;
    public const BEELINE_CODE = 903;
    public const MTS_CODE = 918;
    private const ENEMY_PHONE_COMPANY_RATE = 1;
    private const PHONE_COMPANY_RATE = [
        self::MEGAFON_CODE => 10,
        self::BEELINE_CODE => 5,
        self::MTS_CODE => 3,
    ];

    public const GMAIL_DOMAIN = 'gmail';
    public const YANDEX_DOMAIN = 'yandex';
    public const MAIL_DOMAIN = 'mail';
    private const ENEMY_DOMAIN_RATE = 3;
    private const EMAIL_RATE = [
        self::GMAIL_DOMAIN => 10,
        self::YANDEX_DOMAIN => 8,
        self::MAIL_DOMAIN => 6,
    ];

    private const EDUCATION_RATE = [
        User::SECONDARY => 5,
        User::SPECIAL => 10,
        User::HIGH => 15,
    ];

    private const ZERO_RATE = 0;
    private const PERSONAL_DATA_APPROVED = 4;

    public function getScore(string $phone, ?string $email, ?int $education, bool $personalData): int
    {
        return $this->getPhoneCompanyRate($phone) + $this->getEmailRate($email) + $this->getEducationRate($education) + $this->getPersonalDataRate($personalData);
    }

    private function getPhoneCompanyRate(string $phone): int
    {
        $companyCode = substr($phone, 1, 3);

        return key_exists($companyCode, self::PHONE_COMPANY_RATE) ? self::PHONE_COMPANY_RATE[$companyCode] : self::ENEMY_PHONE_COMPANY_RATE;
    }

    private function getEmailRate(?string $email): int
    {
        $matches = [];
        preg_match('/(?<=@)[^.]+(?=\.)/', $email,$matches);
        $domain = reset($matches);

        if (!is_null($domain) && key_exists($domain, self::EMAIL_RATE)) {
            $rate = self::EMAIL_RATE[$domain];
        } else $rate = self::ENEMY_DOMAIN_RATE;

        return $rate;
    }

    private function getEducationRate(?int $education): int
    {
        if (!is_null($education) && key_exists($education, self::EDUCATION_RATE)) {
            $rate = self::EDUCATION_RATE[$education];
        } else {
            $rate = self::ZERO_RATE;
        }

        return $rate;
    }

    private function getPersonalDataRate(bool $personalData): int
    {
        return $personalData ? self::PERSONAL_DATA_APPROVED : self::ZERO_RATE;
    }
}