<?php

namespace Andaniel05\ComposedViews\Tests\Asset2;

use PHPUnit\Framework\TestCase;
use Andaniel05\ComposedViews\Asset2\ContentScriptAsset;

class ContentScriptAssetTest extends TestCase
{
    use CommonTrait;

    public function newInstance(array $args = [])
    {
        $defaults = [
            'id'      => uniqid(),
            'content' => uniqid(),
            'deps'    => uniqid(),
            'groups'  => uniqid(),
        ];

        $args = array_merge($defaults, $args);
        extract($args);

        return new ContentScriptAsset($id, $content, $deps, $groups);
    }

    public function testTagIsEqualToScript()
    {
        $this->assertEquals('script', $this->asset->getTag());
    }

    public function testHasScriptsGroup()
    {
        $this->assertTrue($this->asset->hasGroup('scripts'));
    }

    public function testHasContentGroup()
    {
        $this->assertTrue($this->asset->hasGroup('content'));
    }

    public function testContentIsEqualToContentArgument()
    {
        $content = uniqid();
        $asset = $this->newInstance(['content' => $content]);

        $this->assertEquals([$content], $asset->getContent());
    }
}
