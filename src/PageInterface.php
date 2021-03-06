<?php

namespace GlueApps\ComposedViews;

use GlueApps\ComposedViews\HtmlElement\HtmlInterface;
use GlueApps\ComposedViews\Component\ComponentInterface;
use GlueApps\ComposedViews\Component\SidebarInterface;
use GlueApps\ComposedViews\Asset\AssetInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * @author Andy Daniel Navarro Taño <andaniel05@gmail.com>
 */
interface PageInterface extends HtmlInterface
{
    public function clone();

    public function getAssets(): array;

    public function traverse(): iterable;

    public function getComponent(string $id): ?ComponentInterface;

    public function getAllVars(): array;

    public function getVar($var);

    public function var($var);

    public function setVar($var, $value);

    public function getAllSidebars(): array;

    public function getSidebar(string $id): ?SidebarInterface;

    public function getAllAssets(): array;

    public function getAsset(string $id): ?AssetInterface;

    public function renderAssets(?string $group = null, bool $filterUnused = true, bool $markUsage = true): string;

    public function renderSidebar(string $sidebarId): string;

    public function renderAsset(string $assetId, bool $required = true, bool $markUsage = true): string;

    public function getOrderedAssets(): array;

    public function basePath(string $assetUri = ''): string;

    public function setBasePath(string $basePath);

    public function addAsset(AssetInterface $asset): void;

    public function setDispatcher(EventDispatcherInterface $dispatcher): void;

    public function getDispatcher(): EventDispatcherInterface;

    public function print(): void;

    public function isPrinted(): bool;

    public function appendComponent(string $parentId, ComponentInterface $component): void;

    public function on(string $eventName, callable $callback): void;
}
