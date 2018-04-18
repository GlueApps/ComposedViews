<?php

namespace GlueApps\ComposedViews\Component;

use GlueApps\ComposedViews\PageInterface;
use GlueApps\ComposedViews\HtmlElement\HtmlInterface;

/**
 * @author Andy Daniel Navarro Taño <andaniel05@gmail.com>
 */
interface ComponentInterface extends HtmlInterface
{
    public function getAssets(): array;

    public function clone();

    public function traverse(): iterable;

    public function getComponent(string $id): ?ComponentInterface;

    public function getId(): string;

    public function setId(string $id);

    public function getParent(): ?ComponentInterface;

    public function setParent(?ComponentInterface $parent, bool $addChild = true);

    public function detach(): void;

    public function renderizeChildren(): ?string;

    public function getChildren(): array;

    public function addChild(ComponentInterface $component, bool $setParent = true);

    public function dropChild(string $id, bool $notifyChild = true);

    public function hasRootChild(string $id): bool;

    public function getPage(): ?PageInterface;

    public function setPage(?PageInterface $page);
}
