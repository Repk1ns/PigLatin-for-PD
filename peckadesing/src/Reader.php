<?php declare(strict_types=1);

namespace PigLatin;

require __DIR__ . '/Translator.php';

class Reader
{

    private $translator;

    public function __construct(\PigLatin\Translator $translator)
    {
        $this->translator = $translator;
    }

    public function readString(): void
    {

        while (!feof(STDIN))
        {
            $line = fgets(STDIN);
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
            echo $finalString;
            echo "\n";
        }
    }
}

$translator = new Reader(new \PigLatin\Translator());
$translator->readString();
