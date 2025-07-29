<?php

namespace App\Policies;

use Spatie\Csp\Directive;
use Spatie\Csp\Keyword;
use Spatie\Csp\Policy as CspPolicy;

class CspMyCustomPolicy extends CspPolicy
{
    public function configure(): void
    {
        // Add default directives first if you want them
        parent::create(); // Uncomment this line to include basic directives like 'self' for scripts, styles, etc.

        // Block framing from any other origin
        $this->add(Directive::FRAME_ANCESTORS, Keyword::NONE);

        // Or, to allow only your own domain to frame it:
        // $this->addDirective(Directive::FRAME_ANCESTORS, Keyword::SELF);

        // Or, to allow specific domains:
        // $this->addDirective(Directive::FRAME_ANCESTORS, [
        //     'https://your-trusted-subdomain.com',
        //     'https://another-internal-app.com',
        // ]);
        

        // Example: If you also want to block scripts from unknown sources (good practice!)
        $this->add(Directive::SCRIPT, Keyword::SELF);
        $this->add(Directive::STYLE, Keyword::SELF);
    }
}
