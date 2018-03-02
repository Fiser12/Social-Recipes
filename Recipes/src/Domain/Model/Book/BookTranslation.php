<?php

namespace Recipes\Domain\Model\Book;

use LIN3S\SharedKernel\Domain\Model\Locale\Locale;
use Recipes\Domain\Model\Name;
use Recipes\Domain\Model\Subtitle;
use Recipes\Domain\Model\Title;
use Recipes\Domain\Model\Translation\Translation;
use Recipes\Domain\Model\User\UserId;

class BookTranslation extends Translation
{
    private $title;
    private $subtitle;

    public function __construct(Locale $locale, Title $title, Subtitle $subtitle)
    {
        parent::__construct($locale);
        $this->title = $title;
        $this->subtitle = $subtitle;
    }

    public function title(): Title
    {
        return $this->title;
    }

    public function subtitle(): Subtitle
    {
        return $this->subtitle;
    }
}