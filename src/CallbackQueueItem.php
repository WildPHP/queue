<?php

use React\Promise\Deferred;
use React\Promise\PromiseInterface;
use WildPHP\Queue\QueueItemInterface;

class CallbackQueueItem implements QueueItemInterface
{
    /**
     * @param Deferred $deferred
     */
public function setDeferred(Deferred $deferred)
    {
        // TODO: Implement setDeferred() method.
    }

    /**
     * @return Deferred
     */
    public function getDeferred(): Deferred
    {
        // TODO: Implement getDeferred() method.
    }

    /**
     * @return PromiseInterface
     */
    public function getPromise(): PromiseInterface
    {
        // TODO: Implement getPromise() method.
    }
}
