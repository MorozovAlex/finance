<?php

namespace App\Service;


use Symfony\Contracts\Translation\TranslatorInterface;

class Translator
{
    public function __construct(
        private readonly TranslatorInterface $translator,
    ){}

    public function trans($code): string
    {
        return $this->translator->trans($code);
    }

}