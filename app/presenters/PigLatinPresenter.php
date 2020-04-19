<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette\Application\UI\Form;

class PigLatinPresenter extends \Nette\Application\UI\Presenter
{
    private $reader;

    public function __construct(\App\PigLatinModule\PigLatinFacade $reader)
    {
        parent::__construct();
        $this->reader = $reader;
    }

    public function renderDefault(): void
    {

    }

    public function createComponentForm()
    {
        $form = new Form();

        $form->addTextArea('Text');
        $form->addSubmit('send', 'Odeslat');
        $form->onSuccess[] = function(Form $form)
        {
            $this->processForm($form);
        };

        return $form;
    }

    private function processForm(Form $form)
    {
        $values = $form->getValues();
        $text = $values->offsetGet('Text');
        $this->flashMessage($this->reader->translateString($text));
    }
}

