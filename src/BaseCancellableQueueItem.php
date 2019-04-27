<?php
/**
 * Copyright 2019 The WildPHP Team
 *
 * You should have received a copy of the MIT license with the project.
 * See the LICENSE file for more information.
 */

declare(strict_types=1);

namespace WildPHP\Queue;

class BaseCancellableQueueItem extends BaseQueueItem implements CancellableQueueItemInterface
{
    /**
     * @var bool
     */
    private $cancelled = false;

    /**
     * @return bool
     */
    public function isCancelled(): bool
    {
        return $this->cancelled;
    }

    /**
     * @return void
     */
    public function cancel()
    {
        $this->getDeferred()->reject();
        $this->cancelled = true;
    }
}
