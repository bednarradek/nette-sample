<?php

namespace App\Presenters;

use App\Helpers\AssetsHelper;
use Nette\Application\UI\Presenter;

abstract class BasePresenter extends Presenter
{
    protected function beforeRender(): void
    {
        parent::beforeRender();

        $this->template->addFunction("css_path", function (): string {
            return AssetsHelper::loadCss();
        });

        $this->template->addFunction("js_path", function (): string {
            return AssetsHelper::loadJs();
        });
    }

}