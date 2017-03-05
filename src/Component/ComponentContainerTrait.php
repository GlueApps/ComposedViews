<?php

namespace PlatformPHP\ComposedViews\Component;

trait ComponentContainerTrait
{
    protected $components = [];

    public function getAllComponents() : array
    {
        return $this->components;
    }

    protected function findOne(array $components, string $id) : ?AbstractComponent
    {
        foreach ($components as $component) {
            if ($id == $component->getId()) {
                return $component;
            } elseif ($component instanceOf AbstractComposedComponent) {
                return $this->findOne($component->getAllComponents(), $id);
            }
        }

        return null;
    }

    public function getComponent(string $id) : ?AbstractComponent
    {
        return $this->findOne($this->getAllComponents(), $id);
    }

    public function addComponent(AbstractComponent $component)
    {
        $this->components[$component->getId()] = $component;
    }

    public function dropComponent(string $id)
    {
        unset($this->components[$id]);
    }

    public function existsComponent(string $id) : bool
    {
        return isset($this->components[$id]);
    }
}