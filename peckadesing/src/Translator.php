<?php declare(strict_types=1);

namespace PigLatin;

require __DIR__ . "/../vendor/autoload.php";

class Translator
{
    private const CONSONANTS = ['b', 'c', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'm', 'n', 'p', 'q', 'r', 's', 't', 'v', 'x', 'y', 'z', 'w','B', 'C', 'D', 'F', 'G', 'H', 'J', 'K', 'L', 'M', 'N', 'P', 'Q', 'R', 'S', 'T', 'V', 'X', 'Y', 'Z', 'W'];
    private const VOWELS = ['a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U'];
    private const COMBINATIONS = ['gu', 'qu'];
    private const SILENT_CONSONANTS = ['kn', 'wr', 'gn', 'ps'];

    private const SUFFIX_WAY = '-way';
    private const SUFFIX_AY = 'ay';

    public function translate(string $word): string
    {
        $word_len = strlen($word);
        $last_symbol = substr($word, $word_len-1, $word_len);

        $is_first_capital = $this->isCapital($word);

        if($this->isVowel($word))
        {
            return $this->translateVowelWord($word, $word_len, $last_symbol);
        }
        elseif($this->isConsonant($word))
        {
            return $this->typeOfConsonantWord($word, $word_len, $last_symbol, $is_first_capital);
        }
        else
        {
            return '';
        }
    }

    public function isCapital(string $word) : bool
    {
        return \Nette\Utils\Strings::match($word[0], '/[A-Z]/') ? TRUE : FALSE;
    }

    public function isVowel(string $letter) : bool
    {
        return in_array($letter[0], self::VOWELS);
    }

    public function isConsonant(string $letter) : bool
    {
        return in_array($letter[0], self::CONSONANTS);
    }

    private function isPunctuationMark(string $last_symbol) : bool
    {
        return \Nette\Utils\Strings::match($last_symbol, '/[.:,!?]/') ? TRUE : FALSE;
    }

    private function translateVowelWord(string $word, int $word_len, string $last_symbol): string
    {
        if($this->isPunctuationMark($last_symbol))
        {
            $word = $this->trimPunct($word, $word_len);
            $word .= self::SUFFIX_WAY . $last_symbol;
        }
        else
        {
            $word .= self::SUFFIX_WAY;
        }
        return $word;
    }

    private function typeOfConsonantWord(string $word, int $word_len, string $last_symbol, bool $is_first_capital): string
    {
        $silent_comb = substr($word, 0, 2);

        if(in_array($silent_comb, self::SILENT_CONSONANTS))
        {
            $word = $this->translateSilentConsonantWord($word, $word_len, $last_symbol);
        }
        elseif(in_array($silent_comb, self::COMBINATIONS))
        {
            $word = $this->translateCombinationConsonantWord($word, $last_symbol, $silent_comb);
        }
        elseif(!\Nette\Utils\Strings::match($word, '/[a,e,i,o,u,A,E,I,O,U]/'))
        {
            $word = $this->translateNoConsonantWord($word, $word_len, $last_symbol, $is_first_capital);
        }
        else
        {
            $word = $this->translateConsonantWord($word, $word_len, $last_symbol, $is_first_capital);
        }
        return $word;
    }

    private function translateSilentConsonantWord(string $word, int $word_len, string $last_symbol): string
    {
        if($this->isPunctuationMark($last_symbol))
        {
            $word = $this->trimPunct($word, $word_len);
            $word .= self::SUFFIX_WAY . $last_symbol;
        }
        else
        {
            $word .= self::SUFFIX_WAY;
        }
        return $word;
    }

    private function translateCombinationConsonantWord(string $word, string $last_symbol, string $silent_comb): string
    {
        $word = substr_replace($word, "", 0, 2);
        $word_len = strlen($word);

        if($this->isPunctuationMark($last_symbol))
        {
            $word = $this->trimPunct($word, $word_len);
            $word .= '-' . $silent_comb . self::SUFFIX_AY . $last_symbol;
        }
        else
        {
            $word .= '-' . $silent_comb . self::SUFFIX_AY;
        }
        return $word;
    }

    private function translateNoConsonantWord(string $word, int $word_len, string $last_symbol, bool $is_first_capital): string
    {
        if($this->isPunctuationMark($last_symbol))
        {
            $word = $this->trimPunct($word, $word_len);
            $word .= self::SUFFIX_WAY . $last_symbol;
        }
        else
        {
            $word .= self::SUFFIX_WAY;
        }
        if($is_first_capital)
        {
            $word[0] = strtoupper($word[0]);
        }
        return $word;
    }


    private function trimPunct(string $word, int $word_len): string
    {
        $word = substr_replace($word, '', $word_len - 1, $word_len);

        return $word;
    }

    private function translateConsonantWord(string $word, int $word_len, string $last_symbol, bool $is_first_capital): string
    {
        for ($i = 1; $i < $word_len; $i++)
        {
            if ($this->isVowel($word[$i]))
            {
                $prefix = substr($word, 0, $i);
                $prefix = strtolower($prefix);
                $word = substr_replace($word, "", 0, $i);
                $word_len = strlen($word);

                if ($this->isPunctuationMark($last_symbol))
                {
                    $word = $this->trimPunct($word, $word_len);
                    $word .= '-' . $prefix . self::SUFFIX_AY . $last_symbol;
                }
                else
                {
                    $word .= '-' . $prefix . self::SUFFIX_AY;
                }
                if ($is_first_capital)
                {
                    $word[0] = strtoupper($word[0]);
                }
                break;
            }
        }
        return $word;
    }
}