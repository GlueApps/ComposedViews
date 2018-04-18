<?php
declare(strict_types=1);

namespace GlueApps\ComposedViews\Traits;

use DeepCopy\DeepCopy;

/**
 * @author Andy Daniel Navarro Taño <andaniel05@gmail.com>
 */
trait CloningTrait
{
    public function clone()
    {
        return (new DeepCopy)->copy($this);
    }
}
