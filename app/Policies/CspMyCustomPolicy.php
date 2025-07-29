<?php

namespace App\Policies;

use Spatie\Csp\Directive;
use Spatie\Csp\Keyword;
use Spatie\Csp\Presets\Preset;

class CspMyCustomPolicy implements Preset
{
    public function configure(): array
    {
        return [
            Directive::FRAME_ANCESTORS => [Keyword::NONE],
            Directive::SCRIPT_SRC => [Keyword::SELF],
            Directive::STYLE_SRC => [Keyword::SELF],
        ];
    }
}