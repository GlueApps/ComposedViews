<?php

namespace PlatformPHP\ComposedViews\Tests;

use PHPUnit\Framework\TestCase;
use PlatformPHP\ComposedViews\Asset2\UrlScriptAsset;

class UrlScriptAssetTest extends TestCase
{
    public function setUp()
    {
        $id = uniqid();

        $this->asset = new UrlScriptAsset($id);
    }

    public function testConstructor()
    {
        $id = uniqid();
        $groups = range(0, rand(0, 10));
        $deps = range(0, rand(0, 10));
        $url = uniqid();
        $minimizedUrl = uniqid();

        $asset = new UrlScriptAsset($id, $groups, $deps, $url, $minimizedUrl);

        $this->assertEquals($id, $asset->getId());
        $this->assertArraySubset($groups, $asset->getGroups());
        $this->assertEquals($deps, $asset->getDependencies());
        $this->assertEquals($url, $asset->getUrl());
        $this->assertEquals($minimizedUrl, $asset->getMinimizedUrl());
    }

    public function testHasUrlGroupByDefault()
    {
        $this->assertTrue($this->asset->inGroup('url'));
    }

    public function testHasScriptsGroupByDefault()
    {
        $this->assertTrue($this->asset->inGroup('scripts'));
    }

    public function testHtml_RenderizeTheMinimizedUrlByDefault()
    {
        $minimizedUrl = uniqid();
        $asset = new UrlScriptAsset('asset', [], [], null, $minimizedUrl);

        $this->assertEquals(
            "<script src=\"$minimizedUrl\">", $asset->html()
        );
    }

    public function testHtml_RenderizeTheUrlWhenAssetHasNotMinimizedStatus()
    {
        $url = uniqid();
        $minimizedUrl = uniqid();
        $asset = new UrlScriptAsset('asset', [], [], $url, $minimizedUrl);
        $asset->setMinimized(false);

        $this->assertEquals(
            "<script src=\"$url\">", $asset->html()
        );
    }
}