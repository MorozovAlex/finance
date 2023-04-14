<?php

namespace App\DataFixtures;

use App\Entity\Email;
use App\Entity\Name;
use App\Entity\Phone;
use App\Entity\User;
use App\Service\ScoreManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixture extends Fixture
{
    public function __construct(
        private readonly ScoreManager $scoreManager,
    ) {}

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 5; $i++) {
            $user = new User();

            $user->setName(self::createName())
                ->setPhone(self::createPhone())
                ->setEmail(self::createEmail())
                ->setEducation(rand(1,3))
                ->setIsPersonalData(rand(0, 1));

            $user->setScore($this->scoreManager->getScore($user->getPhone(), $user->getEmail(), $user->getEducation(), $user->isPersonalData()));

            $manager->persist($user);
        }

        $manager->flush();
    }

    private function createName(): Name
    {
        $firstName = [
            'Ivan',
            'Pol',
            'Juan'
        ];
        $lastName = [
            'Sidorov',
            'Nikolaev',
            'Brysnichkina',
        ];

        return new Name(array_rand(array_flip($firstName)), null, array_rand(array_flip($lastName)));
    }

    private function createPhone(): Phone
    {
        $phoneCode = [
            ScoreManager::MEGAFON_CODE,
            ScoreManager::BEELINE_CODE,
            ScoreManager::MTS_CODE,
            999,
        ];

        return new Phone('+7' . array_rand(array_flip($phoneCode)) . rand(1000000, 9999999));
    }

    private function createEmail(): Email
    {
        $domain = [
            ScoreManager::GMAIL_DOMAIN,
            ScoreManager::YANDEX_DOMAIN,
            ScoreManager::MAIL_DOMAIN,
            'list',
        ];

        return new Email(rand(100, 1000) . '@' . array_rand(array_flip($domain)) . '.com');
    }
}
