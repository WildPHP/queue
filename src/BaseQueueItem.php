<?php
/**
 * Copyright 2019 The WildPHP Team
 *
 * You should have received a copy of the MIT license with the project.
 * See the LICENSE file for more information.
 */

declare(strict_types=1);

namespace WildPHP\Queue;

use React\Promise\Deferred;
use React\Promise\PromiseInterface;

class BaseQueueItem implements QueueItemInterface
{
    /**
     * @var Deferred
     */
    private $deferred;

    /**
     * CallbackQueueItem constructor.
     */
    public function __construct()
    {
        $this->deferred = new Deferred();
    }

    /**
     * @return Deferred
     */
    public function getDeferred(): Deferred
    {
        return $this->deferred;
    }

    /**
     * @return PromiseInterface
     */
    public function getPromise(): PromiseInterface
    {
        return $this->getDeferred()->promise();
    }
}
