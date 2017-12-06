<?php
declare(strict_types=1);

namespace Andaniel05\ComposedViews\Traits;

use DeepCopy\DeepCopy;

trait CloningTrait
{
    public function clone()
    {
        return (new DeepCopy)->copy($this);
    }
}
