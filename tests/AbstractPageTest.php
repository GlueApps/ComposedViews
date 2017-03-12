<?php

namespace PlatformPHP\ComposedViews\Tests;

use PlatformPHP\ComposedViews\AbstractPage;
use PlatformPHP\ComposedViews\Component\AbstractComponent;
use PlatformPHP\ComposedViews\Sidebar\Sidebar;
use PlatformPHP\ComposedViews\Tests\TestCase;
use PlatformPHP\ComposedViews\Tests\Traits\{PrintTraitTests, CloningTraitTests};
use PlatformPHP\ComposedViews\Tests\Asset\AssetsTraitTests;

class AbstractPageTest extends TestCase
{
    use PrintTraitTests, AssetsTraitTests, CloningTraitTests;

    public function setUp()
    {
        $this->page = $this->getMockForAbstractClass(AbstractPage::class);
    }

    public function getTestClass()
    {
        return AbstractPage::class;
    }

    public function testAssetsInitializationOnConstructor()
    {
        $page = $this->getMockBuilder(AbstractPage::class)
            ->disableOriginalConstructor()
            ->setMethods(['initializeAssets'])
            ->getMockForAbstractClass();
        $page->expects($this->once())
            ->method('initializeAssets');

        $page->__construct();
    }

    public function testVarsInitializationOnConstructor()
    {
        $page = $this->getMockBuilder(AbstractPage::class)
            ->disableOriginalConstructor()
            ->setMethods(['initializeVars'])
            ->getMockForAbstractClass();
        $page->expects($this->once())
            ->method('initializeVars');

        $page->__construct();
    }

    public function testGetVarsReturnAnEmptyArrayByDefault()
    {
        $this->assertEquals([], $this->page->getAllVars());
    }

    public function provider1()
    {
        return [
            [ [] ],
            [ ['var1' => 'value1'] ],
        ];
    }

    /**
     * @dataProvider provider1
     */
    public function testGetVarsReturnSameResultThatVarsAfterInitialization($vars)
    {
        $page = $this->getMockBuilder(AbstractPage::class)
            ->disableOriginalConstructor()
            ->setMethods(['vars'])
            ->getMockForAbstractClass();
        $page->expects($this->once())
            ->method('vars')->willReturn($vars);

        $page->__construct();

        $this->assertEquals($vars, $page->getAllVars());
    }

    public function getMock1()
    {
        $vars = [
            'var1' => 'value1',
            'value2',
            'var3' => 'value3',
        ];

        $page = $this->getMockBuilder(AbstractPage::class)
            ->disableOriginalConstructor()
            ->setMethods(['vars'])
            ->getMockForAbstractClass();
        $page->expects($this->once())
            ->method('vars')->willReturn($vars);
        $page->__construct();

        return $page;
    }

    public function testGetVarReturnTheValueOfTheVar()
    {
        $page = $this->getMock1();

        $this->assertEquals('value1', $page->getVar('var1'));
        $this->assertEquals('value2', $page->getVar(0));
        $this->assertEquals('value3', $page->getVar('var3'));
    }

    public function testGetVarReturnNullIfVarNotExists()
    {
        $page = $this->getMock1();

        $this->assertNull($page->getVar('var100'));
    }

    public function testSetVarChangeTheValueOfTheVar()
    {
        $page = $this->getMock1();

        $page->setVar('var1', 'new value1');
        $page->setVar(0, 'new value2');

        $this->assertEquals('new value1', $page->getVar('var1'));
        $this->assertEquals('new value2', $page->getVar(0));
    }

    public function testSetVarDoNotInsertNewVars()
    {
        $page = $this->getMock1();

        $page->setVar('var100', 'value100');

        $expectedVars = [
            'var1' => 'value1',
            'value2',
            'var3' => 'value3',
        ];

        $this->assertEquals($expectedVars, $page->getAllVars());
    }

    public function testGetVarsReturnAnArrayWithAllChangedVars()
    {
        $page = $this->getMock1();

        $page->setVar('var1', 'new value1');
        $page->setVar(0, 'new value2');
        $page->setVar('var3', 'new value3');

        $expectedVars = [
            'var1' => 'new value1',
            'new value2',
            'var3' => 'new value3',
        ];

        $this->assertEquals($expectedVars, $page->getAllVars());
    }

    public function testPrintVarDoNotPrintNothingIfVarNotExists()
    {
        $page = $this->getMock1();

        $page->printVar('var100');

        $this->expectOutputString(null);
    }

    public function testPrintVarPrintInTheOutputTheValueOfVar()
    {
        $page = $this->getMock1();

        $page->printVar('var1');

        $this->expectOutputString('value1');
    }

    public function testSidebarInitializationOnConstructor()
    {
        $page = $this->getMockBuilder(AbstractPage::class)
            ->disableOriginalConstructor()
            ->setMethods(['initializeSidebars'])
            ->getMockForAbstractClass();
        $page->expects($this->once())
            ->method('initializeSidebars');

        $page->__construct();
    }

    public function testSidebarsReturnAnEmptyArrayByDefault()
    {
        $page = $this->getMockBuilder(AbstractPage::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();

        $this->assertEquals([], $page->getAllSidebars());
    }

    public function getMock2(array $sidebars)
    {
        $page = $this->getMockBuilder(AbstractPage::class)
            ->disableOriginalConstructor()
            ->setMethods(['sidebars'])
            ->getMockForAbstractClass();
        $page->expects($this->once())
            ->method('sidebars')->willReturn($sidebars);
        $page->__construct();

        return $page;
    }

    public function testGetSidebarsReturnAnEmptyArrayWhenSidebarsReturnAnEmptyArrayToo()
    {
        $page = $this->getMock2([]);

        $this->assertEquals([], $page->getAllSidebars());
    }

    public function provider2()
    {
        return [
            [ [], 0 ],
            [ ['sidebar1'], 1 ],
            [ ['sidebar1', 'sidebar2'], 2 ],
            [ ['sidebar1', 1, 123.45, true, null, 'sidebar2'], 2 ],
        ];
    }

    /**
     * @dataProvider provider2
     */
    public function testNumberOfSidebarsPerResultsOfSidebars($def, $total)
    {
        $page = $this->getMock2($def);

        $sidebars = $page->getAllSidebars();

        $this->assertCount($total, $sidebars);
        $this->assertContainsOnlyInstancesOf(Sidebar::class, $sidebars);
    }

    public function testGetSidebarReturnNullIfSidebarNotExists()
    {
        $page = $this->getMock2(['sidebar1', 'sidebar2']);

        $this->assertNull($page->getSidebar('sidebar3'));
    }

    public function testGetSidebarReturnTheSidebarIfExists()
    {
        $page = $this->getMock2(['sidebar1', 'sidebar2']);

        $sidebar1 = $page->getSidebar('sidebar1');

        $this->assertInstanceOf(Sidebar::class, $sidebar1);
        $this->assertEquals('sidebar1', $sidebar1->getId());
    }

    public function testInsertionOfComponentsInSidebarOnDefinition()
    {
        $component1 = $this->createMock(AbstractComponent::class);
        $component1->method('getId')->willReturn('component1');

        $component2 = $this->createMock(AbstractComponent::class);
        $component2->method('getId')->willReturn('component2');

        $page = $this->getMock2([
            'sidebar1' => [
                $component1, 'string', true, null, 123,
                123.45, $component2,
            ],
        ]);

        $sidebar1 = $page->getSidebar('sidebar1');

        $expected = [
            'component1' => $component1,
            'component2' => $component2,
        ];

        $this->assertEquals($expected, $sidebar1->getAllComponents());
    }

    public function testPrintSidebarInvokePrintMethodInTheSidebar()
    {
        $sidebar1 = $this->getMockBuilder(Sidebar::class)
            ->disableOriginalConstructor()
            ->setMethods(['print'])
            ->getMock();
        $sidebar1->expects($this->once())
            ->method('print');

        $page = $this->getMockBuilder(AbstractPage::class)
            ->disableOriginalConstructor()
            ->setMethods(['getSidebar'])
            ->getMockForAbstractClass();
        $page->expects($this->once())
            ->method('getSidebar')
            ->with($this->equalTo('sidebar1'))
            ->willReturn($sidebar1);

        $page->printSidebar('sidebar1');
    }

    public function initializeSidebarsWithEqualsComponents()
    {
        $this->component1 = $this->createMock(AbstractComponent::class);
        $this->component1->method('getId')->willReturn('component1');

        $this->component2 = $this->createMock(AbstractComponent::class);
        $this->component2->method('getId')->willReturn('component1');

        $this->page = $this->getMockBuilder(AbstractPage::class)
            ->disableOriginalConstructor()
            ->setMethods(['sidebars'])
            ->getMockForAbstractClass();
        $this->page->method('sidebars')
            ->willReturn([
                'sidebar1' => [$this->component1],
                'sidebar2' => [$this->component2],
            ]);

        $this->page->__construct();
    }

    public function testGetComponentReturnTheFirstComponentWhereIdMatch()
    {
        $this->initializeSidebarsWithEqualsComponents();

        $this->assertSame(
            $this->component1,
            $this->page->getComponent('component1')
        );
    }

    public function testGetComponentSearchTheComponentInsideTheSidebar()
    {
        $this->initializeSidebarsWithEqualsComponents();

        $this->assertSame(
            $this->component2,
            $this->page->getComponent('sidebar2 component1')
        );
    }

    public function provider3()
    {
        return [
            ['component1 component2'],
            ['component3 component4'],
        ];
    }

    /**
     * @dataProvider provider3
     */
    public function testGetComponentDelegateInGetComponentInAllSidebarsWhenPatternNotStartBySidebarId($componentId)
    {
        $page = $this->getMockBuilder(AbstractPage::class)
            ->disableOriginalConstructor()
            ->setMethods(['getComponentInAllSidebars'])
            ->getMockForAbstractClass();
        $page->expects($this->once())
            ->method('getComponentInAllSidebars')
            ->with($this->equalTo($componentId));
        $page->__construct();

        $page->getComponent($componentId);
    }

    public function testGetPageAssetsReturnAnEmptyArrayByDefault()
    {
        $this->assertEquals([], $this->page->getPageAssets());
    }

    public function testGetPageAssetsIsAliasOfAssetsTraitGetAssets()
    {
        $def = [
            'styles' => [
                ['bootstrap', '/css/bootstrap.css', [], ],
                ['custom', '/css/custom.css', ['bootstrap'], '* {color: black}'],
            ],
            'scripts' => [
                ['jquery', '/js/jquery.js'],
            ],
        ];

        $page = $this->getMockBuilder(AbstractPage::class)
            ->disableOriginalConstructor()
            ->setMethods(['assets'])
            ->getMockForAbstractClass();
        $page->method('assets')->willReturn($def);
        $page->__construct();

        $this->assertCount(3, $page->getPageAssets());
    }
}