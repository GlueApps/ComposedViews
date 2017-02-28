<?php

namespace PlatformPHP\ComposedViews\Asset;

class Asset implements AssetInterface
{
    protected $id;
    protected $type;
    protected $url;
    protected $deps;
    protected $content;

    public function __construct(string $id, string $type, string $url, array $deps = [], ?string $content = null)
    {
        $this->id      = $id;
        $this->type    = $type;
        $this->url     = $url;
        $this->deps    = $deps;
        $this->content = $content;
    }

    public function getId() : string
    {
        return $this->id;
    }

    public function getType() : string
    {
        return $this->type;
    }

    public function getUrl() : string
    {
        return $this->url;
    }

    public function setUrl(string $url)
    {
        $this->url = $url;

        return $this;
    }

    public function getContent() : ?string
    {
        return $this->content;
    }

    public function setContent(?string $content)
    {
        $this->content = $content;

        return $this;
    }

    public function getDependencies() : array
    {
        return $this->deps;
    }
}