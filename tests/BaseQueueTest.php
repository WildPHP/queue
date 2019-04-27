<?php
/**
 * Copyright 2019 The WildPHP Team
 *
 * You should have received a copy of the MIT license with the project.
 * See the LICENSE file for more information.
 */

declare(strict_types=1);

namespace WildPHP\Queue\Tests;

use PHPUnit\Framework\TestCase;
use WildPHP\Queue\BaseQueue;
use WildPHP\Queue\BaseQueueItem;
use WildPHP\Queue\QueueException;

class BaseQueueTest extends TestCase
{
    public function testDequeue()
    {
        $queue = new BaseQueue();
        $queueItem = new BaseQueueItem();

        $queue->enqueue($queueItem);
        $this->assertEquals([$queueItem], $queue->toArray());
        $queue->dequeue($queueItem);
        $this->assertEquals([], $queue->toArray());

        $this->expectException(QueueException::class);
        $queue->dequeue($queueItem);
    }

    public function testEnqueue()
    {
        $queue = new BaseQueue();
        $queueItem = new BaseQueueItem();

        $this->assertEquals([], $queue->toArray());
        $queue->enqueue($queueItem);
        $this->assertEquals([$queueItem], $queue->toArray());
    }

    public function testHas()
    {
        $queue = new BaseQueue();
        $queueItem = new BaseQueueItem();

        $this->assertFalse($queue->has($queueItem));
        $queue->enqueue($queueItem);
        $this->assertTrue($queue->has($queueItem));
    }

    public function testRemove()
    {
        $queue = new BaseQueue();
        $queueItem = new BaseQueueItem();

        $queue->enqueue($queueItem);
        $this->assertEquals([$queueItem], $queue->toArray());
        $queue->remove($queueItem);
        $this->assertEquals([], $queue->toArray());

        $this->expectException(QueueException::class);
        $queue->remove($queueItem);
    }

    public function testClear()
    {
        $queue = new BaseQueue();
        $queueItem = new BaseQueueItem();

        $queue->enqueue($queueItem);
        $queue->clear();

        $this->assertEquals([], $queue->toArray());
    }
}
