<?php

namespace Andaniel05\ComposedViews\Tests\Asset;

use PHPUnit\Framework\TestCase;
use Andaniel05\ComposedViews\Asset\{ScriptAsset, UriInterface};

class ScriptAssetTest extends TestCase
{
    use CommonTrait;

    public function newInstance(array $args = [])
    {
        $defaults = [
            'id'     => uniqid(),
            'uri'    => uniqid(),
            'deps'   => uniqid(),
            'groups' => uniqid(),
        ];

        $args = array_merge($defaults, $args);
        extract($args);

        return new ScriptAsset($id, $uri, $deps, $groups);
    }

    public function testTagIsEqualToScript()
    {
        $this->assertEquals('script', $this->asset->getTag());
    }

    public function testHasScriptsGroup()
    {
        $this->assertTrue($this->asset->hasGroup('scripts'));
    }

    public function testHasUriGroup()
    {
        $this->assertTrue($this->asset->hasGroup('uri'));
    }

    public function testSrcAttributeIsEqualToUriArgument()
    {
        $uri = uniqid();
        $asset = $this->newInstance(['uri' => $uri]);

        $this->assertEquals($uri, $asset->getAttribute('src'));
    }

    public function testSetUriChangeTheSrcAttribute()
    {
        $uri = uniqid();
        $this->asset->setUri($uri);

        $this->assertEquals($uri, $this->asset->getAttribute('src'));
    }

    public function testGetUriReturnResultOfSrcAttribute()
    {
        $uri = uniqid();
        $this->asset->setAttribute('src', $uri);

        $this->assertEquals($uri, $this->asset->getUri());
    }

    public function testIsInstanceOfUriInterface()
    {
        $this->assertInstanceOf(UriInterface::class, $this->asset);
    }
}
