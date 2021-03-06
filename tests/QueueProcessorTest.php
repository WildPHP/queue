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
use WildPHP\Queue\BaseQueue;
use WildPHP\Queue\BaseQueueItem;
use WildPHP\Queue\QueueProcessor;
use function Clue\React\Block\await;
use function Clue\React\Block\sleep as blockSleep;

class QueueProcessorTest extends TestCase
{

    public function testProcessSingleItem()
    {
        $queue = new BaseQueue();
        $queueItem = new BaseQueueItem();
        $queue->enqueue($queueItem);

        $loop = Factory::create();
        $processor = new QueueProcessor($queue, $loop);

        $this->assertSame($queueItem, await($queueItem->getPromise(), $loop, 1));
    }

    public function testProcessDequeuedItem()
    {
        $queue = new BaseQueue();
        $queueItem = new BaseQueueItem();
        $queue->enqueue($queueItem);
        $queue->dequeue($queueItem);

        $loop = Factory::create();
        $processor = new QueueProcessor($queue, $loop);

        $this->expectException(Exception::class);
        await($queueItem->getPromise(), $loop, 1);
    }

    public function testProcessRemovedItem()
    {
        $queue = new BaseQueue();
        $queueItem = new BaseQueueItem();
        $queue->enqueue($queueItem);
        $queue->remove($queueItem);

        $loop = Factory::create();
        $processor = new QueueProcessor($queue, $loop);

        $this->expectException(TimeoutException::class);
        await($queueItem->getPromise(), $loop, 1);
    }

    public function testBurst()
    {
        $queue = new BaseQueue();
        $queueItem1 = new BaseQueueItem();
        $queueItem2 = new BaseQueueItem();
        $queueItem3 = new BaseQueueItem();
        $queueItem4 = new BaseQueueItem();
        $queueItem5 = new BaseQueueItem();
        $queue->enqueue($queueItem1);
        $queue->enqueue($queueItem2);
        $queue->enqueue($queueItem3);
        $queue->enqueue($queueItem4);
        $queue->enqueue($queueItem5);

        $loop = Factory::create();
        $processor = new QueueProcessor($queue, $loop);

        $this->assertTrue($processor->shouldUseBurst(5));
        $this->assertSame($queueItem5, await($queueItem5->getPromise(), $loop, 1));
        blockSleep(1, $loop);
    }

    public function testDefaultValues()
    {
        $queue = new BaseQueue();
        $loop = Factory::create();
        $processor = new QueueProcessor($queue, $loop);

        $this->assertEquals(1, $processor->getMessagesPerSecond());
        $this->assertEquals(3, $processor->getBurstTrigger());
        $this->assertEquals(5, $processor->getBurstAmount());

        $processor->setMessagesPerSecond(2);
        $processor->setBurstTrigger(4);
        $processor->setBurstAmount(6);

        $this->assertEquals(2, $processor->getMessagesPerSecond());
        $this->assertEquals(4, $processor->getBurstTrigger());
        $this->assertEquals(6, $processor->getBurstAmount());
    }
}
