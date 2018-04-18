<?php
declare(strict_types=1);

namespace GlueApps\ComposedViews\Asset;

/**
 * @author Andy Daniel Navarro Taño <andaniel05@gmail.com>
 */
class StyleAsset extends AbstractAsset implements UriInterface
{
    public function __construct(string $id, string $uri, string $dependencies = '', string $groups = '')
    {
        parent::__construct($id);

        if ($dependencies) {
            $this->addDependency($dependencies);
        }

        $this->addGroup("styles uri {$groups}");
        $this->setTag('link');
        $this->setAttribute('href', $uri);
        $this->setAttribute('rel', 'stylesheet');
        $this->setEndTag(false);
    }

    public function getUri(): string
    {
        return $this->getAttribute('href');
    }

    public function setUri(string $uri)
    {
        $this->setAttribute('href', $uri);
    }
}
