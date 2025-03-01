<?php

namespace Tests;

use Laravel\Dusk\Browser as BaseBrowser;

class Browser extends BaseBrowser
{
    public function withinModal(callable $callable): self
    {
        return $this->within('@modal-content', $callable);
    }

    public function waitForModal(): self
    {
        return $this->waitFor('@modal-content');
    }

    public function waitUntilMissingModal(): self
    {
        return $this->waitUntilMissing('@modal-wrapper');
    }
}
