<?php

namespace GlueApps\ComposedViews\Tests\Builder;

use GlueApps\ComposedViews\Component\AbstractComponent;

/**
 * @author Andy Daniel Navarro Taño <andaniel05@gmail.com>
 */
class Component extends AbstractComponent
{
    public function html(): ?string
    {
        return '';
    }
}
