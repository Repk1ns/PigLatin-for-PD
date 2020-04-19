<?php declare(strict_types=1);

require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/../../app/PigLatinModule/Translator.php';

class TranslatorTest extends \Tester\TestCase
{
    public function getTranslator(): \App\PigLatinModule\Translator
    {
        return new \App\PigLatinModule\Translator();
    }

    public function testTranslate(): void
    {
        \Tester\Assert::same('est-tay', $this->getTranslator()->translate('test'));
    }

    public function testSilentConsonants(): void
    {
        \Tester\Assert::same('kneel-way', $this->getTranslator()->translate('kneel'));
    }

    public function testCombinationConsonants(): void
    {
        \Tester\Assert::same('estion-quay', $this->getTranslator()->translate('question'));
    }

    public function testNoConsonants(): void
    {
        \Tester\Assert::same('dry-way', $this->getTranslator()->translate('dry'));
    }

    public function testIsCapital(): void
    {
        \Tester\Assert::true($this->getTranslator()->isCapital('Hello'));
    }

    public function testIsNotCapital(): void
    {
        \Tester\Assert::false($this->getTranslator()->isCapital('world'));
    }

    public function testIsVowel(): void
    {
        \Tester\Assert::true($this->getTranslator()->isVowel('ignore'));
    }

    public function testIsNotVowel(): void
    {
        \Tester\Assert::false($this->getTranslator()->isVowel('ginger'));
    }

    public function testIsConsonant(): void
    {
        \Tester\Assert::true($this->getTranslator()->isConsonant('guess'));
    }

    public function testIsNotConsonant(): void
    {
        \Tester\Assert::false($this->getTranslator()->isConsonant('air'));
    }
}

(new TranslatorTest())->run();
