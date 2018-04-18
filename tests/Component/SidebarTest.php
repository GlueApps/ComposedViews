<?php

namespace GlueApps\ComposedViews\Tests\Component;

use GlueApps\ComposedViews\Component\AbstractComponent;
use GlueApps\ComposedViews\Component\Sidebar;
use PHPUnit\Framework\TestCase;

/**
 * @author Andy Daniel Navarro Taño <andaniel05@gmail.com>
 */
class SidebarTest extends TestCase
{
    public function testGetIdReturnIdArgument()
    {
        $sidebarId = uniqid();

        $sidebar = new Sidebar($sidebarId);

        $this->assertEquals($sidebarId, $sidebar->getId());
    }

    public function testTheHtmlHasAContainer()
    {
        $id = uniqid();
        $childrenHtml = uniqid();
        $sidebar = $this->getMockBuilder(Sidebar::class)
            ->setConstructorArgs([$id])
            ->setMethods(['renderizeChildren'])
            ->getMock();
        $sidebar->method('renderizeChildren')->willReturn($childrenHtml);

        $expectedXML = <<<XML
<div id="cv-sidebar-{$id}" class="cv-sidebar cv-sidebar-{$id}">
    {$childrenHtml}
</div>
XML;
        $this->assertXmlStringEqualsXmlString(
            $expectedXML, $sidebar->html()
        );
    }
}
