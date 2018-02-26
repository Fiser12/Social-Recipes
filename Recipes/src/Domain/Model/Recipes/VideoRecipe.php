<?php

namespace Recipes\Domain\Model\Recipes;

use Recipes\Domain\Model\Subtitle;
use Recipes\Domain\Model\Title;
use Recipes\Domain\Model\Video;

/**
 * @author Rubén García <ruben.garcia@opendeusto.es>
 */
class VideoRecipe
{
    private $id;

    private $title;
    private $subtitle;
    private $video;

    public function __construct(VideoRecipeId $id, Title $title, Subtitle $subtitle, Video $video)
    {
        $this->id = $id;
        $this->title = $title;
        $this->subtitle = $subtitle;
        $this->video = $video;
    }

    public function id(): VideoRecipeId
    {
        return $this->id;
    }

    public function title(): Title
    {
        return $this->title;
    }

    public function subtitle(): Subtitle
    {
        return $this->subtitle;
    }

    public function video(): Video
    {
        return $this->video;
    }
}