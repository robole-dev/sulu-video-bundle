<?php

namespace Robole\SuluVideoBundle\Content\Types;

use Sulu\Component\Content\SimpleContentType;

class Video extends SimpleContentType
{
    public function __construct()
    {
        parent::__construct('video', '');
    }
}
