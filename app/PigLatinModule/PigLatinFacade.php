<?php declare(strict_types=1);

namespace App\PigLatinModule;


class PigLatinFacade
{

    private $translator;

    public function __construct(\App\PigLatinModule\Translator $translator)
    {
        $this->translator = $translator;
    }

    public function translateString($line): string
    {
        $words = explode(' ', trim($line));

        $translatedArray = array();

        foreach ($words as $word)
        {
            if($word === '')
            {
                continue;
            }
            array_push($translatedArray, $this->translator->translate($word));
        }
        $finalString = implode(' ', $translatedArray);
        return $finalString;
    }
}

