<?php
/**
 * Copyright 2019 The WildPHP Team
 *
 * You should have received a copy of the MIT license with the project.
 * See the LICENSE file for more information.
 */

namespace WildPHP\Queue\Tests;

use Exception;
use PHPUnit\Framework\TestCase;
use React\EventLoop\Factory;
use React\Promise\Timer\TimeoutException;
use WildPHP\Queue\BaseCancellableQueueItem;
use function Clue\React\Block\await;

class BaseCancellableQueueItemTest extends TestCase
{
    public function testIsCancelled()
    {
        $cancellableQueueItem = new BaseCancellableQueueItem();
        $this->assertFalse($cancellableQueueItem->isCancelled());
        $cancellableQueueItem->cancel();
        $this->assertTrue($cancellableQueueItem->isCancelled());
    }

    public function testCancel()
    {
        $cancellableQueueItem = new BaseCancellableQueueItem();
        $loop = Factory::create();
        $cancellableQueueItem->cancel();

        $this->expectException(Exception::class);
        await($cancellableQueueItem->getPromise(), $loop, 0.0001);
    }

    public function testNotCancelled()
    {
        $cancellableQueueItem = new BaseCancellableQueueItem();
        $loop = Factory::create();

        $this->expectException(TimeoutException::class);
        await($cancellableQueueItem->getPromise(), $loop, 0.0001);
    }
}
