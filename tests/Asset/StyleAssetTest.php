<?php

namespace GlueApps\ComposedViews\Tests\Asset;

use PHPUnit\Framework\TestCase;
use GlueApps\ComposedViews\Asset\StyleAsset;
use GlueApps\ComposedViews\Asset\UriInterface;

/**
 * @author Andy Daniel Navarro Taño <andaniel05@gmail.com>
 */
class StyleAssetTest extends TestCase
{
    use CommonTrait, CommonStyleImportTrait;

    public function newInstance(array $args = [])
    {
        $defaults = [
            'id'     => uniqid(),
            'uri'    => '',
            'deps'   => '',
            'groups' => '',
        ];

        $args = array_merge($defaults, $args);
        extract($args);

        return new StyleAsset($id, $uri, $deps, $groups);
    }

    public function testHasStylesGroup()
    {
        $this->assertTrue($this->asset->hasGroup('styles'));
    }

    public function testHasRelAttributeEqualToStylesheet()
    {
        $this->assertEquals('stylesheet', $this->asset->getAttribute('rel'));
    }
}
