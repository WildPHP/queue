<?php
/**
 * Copyright 2019 The WildPHP Team
 *
 * You should have received a copy of the MIT license with the project.
 * See the LICENSE file for more information.
 */

declare(strict_types=1);

namespace WildPHP\Queue;

use PHPUnit\Framework\TestCase;
use React\Promise\Deferred;
use React\Promise\PromiseInterface;

class BaseQueueItemTest extends TestCase
{

    public function testGetDeferred()
    {
        $queueItem = new BaseQueueItem();
        $this->assertInstanceOf(Deferred::class, $queueItem->getDeferred());
    }

    public function testGetPromise()
    {
        $queueItem = new BaseQueueItem();
        $this->assertInstanceOf(PromiseInterface::class, $queueItem->getPromise());
    }
}
