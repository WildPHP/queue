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
use WildPHP\Queue\CallbackQueueItem;
use function Clue\React\Block\await;

class CallbackQueueItemTest extends TestCase
{
    public function testCallbackSuccess()
    {
        $callbackQueueItem = new CallbackQueueItem(function () {
            $this->assertTrue(true);
        }, function () {
            $this->fail('Should not call onFailure');
        });

        $loop = Factory::create();
        $callbackQueueItem->getDeferred()->resolve();
        await($callbackQueueItem->getPromise(), $loop, 0.0001);
    }

    public function testCallbackFailure()
    {
        $callbackQueueItem = new CallbackQueueItem(function () {
            $this->fail('Should not call onSuccess');
        }, function () {
            $this->assertTrue(true);
        });

        $loop = Factory::create();
        $callbackQueueItem->getDeferred()->reject();
        $this->expectException(Exception::class);
        await($callbackQueueItem->getPromise(), $loop, 0.0001);
    }
}
