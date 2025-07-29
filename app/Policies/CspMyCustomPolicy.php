<?php

namespace App\Policies;

use Spatie\Csp\Directive;
use Spatie\Csp\Keyword;
use Spatie\Csp\Policy;
use Spatie\Csp\Preset;

class CspMyCustomPolicy implements Preset
{
    public function configure(Policy $policy):void
    {
        $policy->add(Directive::FRAME_ANCESTORS, Keyword::NONE);
    }
}