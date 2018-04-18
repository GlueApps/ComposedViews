<?php

namespace GlueApps\ComposedViews\Tests\Asset;

use GlueApps\ComposedViews\Asset\UriInterface;

/**
 * @author Andy Daniel Navarro Taño <andaniel05@gmail.com>
 */
trait CommonStyleImportTrait
{
    public function testIsInstanceOfUriInterface()
    {
        $this->assertInstanceOf(UriInterface::class, $this->asset);
    }

    public function testTagIsEqualToLink()
    {
        $this->assertEquals('link', $this->asset->getTag());
    }

    public function testHasNotEndTag()
    {
        $this->assertFalse($this->asset->getEndTag());
    }

    public function testHasUriGroup()
    {
        $this->assertTrue($this->asset->hasGroup('uri'));
    }

    public function testHrefAttributeIsEqualToUriArgument()
    {
        $uri = uniqid();
        $asset = $this->newInstance(['uri' => $uri]);

        $this->assertEquals($uri, $asset->getAttribute('href'));
    }

    public function testSetUriChangeTheHrefAttribute()
    {
        $uri = uniqid();
        $this->asset->setUri($uri);

        $this->assertEquals($uri, $this->asset->getAttribute('href'));
    }

    public function testGetUriReturnResultOfHrefAttribute()
    {
        $uri = uniqid();
        $this->asset->setAttribute('href', $uri);

        $this->assertEquals($uri, $this->asset->getUri());
    }
}
