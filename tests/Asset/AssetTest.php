<?php

namespace PlatformPHP\ComposedViews\Tests;

use PHPUnit\Framework\TestCase;
use PlatformPHP\ComposedViews\Asset\Asset;

class AssetTest extends TestCase
{
    public function setUp()
    {
        $this->asset = new Asset('id', 'group', 'url');
    }

    public function provider1()
    {
        return [
            ['asset1', 'group1', 'url1', [], 'content1'],
            ['asset2', 'group2', 'url2', ['asset1'], 'content2'],
        ];
    }

    /**
     * @dataProvider provider1
     */
    public function testArgumentGetters($id, $group, $url, $deps, $content)
    {
        $asset = new Asset($id, $group, $url, $deps, $content);

        $this->assertEquals($id, $asset->getId());
        $this->assertEquals($group, $asset->getGroup());
        $this->assertEquals($url, $asset->getUrl());
        $this->assertEquals($deps, $asset->getDependencies());
        $this->assertEquals($content, $asset->getContent());
    }

    public function testSetUrlReturnToOneSelf()
    {
        $this->assertSame($this->asset, $this->asset->setUrl('url'));
    }

    public function provider2()
    {
        return [
            ['url1'],
            ['url2'],
        ];
    }

    /**
     * @dataProvider provider2
     */
    public function testGetUrlReturnInsertedValueBySetUrl($url)
    {
        $this->asset->setUrl($url);

        $this->assertSame($url, $this->asset->getUrl());
    }

    public function testSetContentReturnToOneSelf()
    {
        $this->assertSame($this->asset, $this->asset->setContent('content'));
    }

    public function provider3()
    {
        return [
            ['content1'],
            [null],
        ];
    }

    /**
     * @dataProvider provider3
     */
    public function testGetContentReturnInsertedValueBySetContent($content)
    {
        $this->asset->setContent($content);

        $this->assertSame($content, $this->asset->getContent());
    }

    public function testIsUsedReturnFalseByDefault()
    {
        $this->assertFalse($this->asset->isUsed());
    }

    public function testIsUsedReturnInsertedBySetUsed()
    {
        $this->asset->setUsed(true);

        $this->assertTrue($this->asset->isUsed());
    }

    public function testGetAndSetGroup()
    {
        $group = uniqid();

        $this->asset->setGroup($group);

        $this->assertEquals($group, $this->asset->getGroup());
    }
}