<?php

namespace GlueApps\ComposedViews\Tests\Builder;

use GlueApps\ComposedViews\AbstractPage;

/**
 * @author Andy Daniel Navarro Taño <andaniel05@gmail.com>
 */
class Page extends AbstractPage
{
    public function sidebars(): array
    {
        return ['sidebar1', 'sidebar2'];
    }

    public function html(): ?string
    {
        return '';
    }
}
