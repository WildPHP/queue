<?php
/**
 * Copyright 2019 The WildPHP Team
 *
 * You should have received a copy of the MIT license with the project.
 * See the LICENSE file for more information.
 */

declare(strict_types=1);

namespace WildPHP\Queue;

use React\Promise\PromiseInterface;

/**
 * Interface QueueInterface
 * @package WildPHP\Core\Queue
 */
interface QueueInterface
{
    /**
     * @param QueueItemInterface $queueItem
     * @return PromiseInterface
     */
    public function enqueue(QueueItemInterface $queueItem): PromiseInterface;

    /**
     * Removes an item from the queue while not rejecting the associated promise.
     * @param QueueItemInterface $queueItem
     * @throws QueueException when the item is not found
     */
    public function remove(QueueItemInterface $queueItem);

    /**
     * Removes an item from the queue while also rejecting the associated promise.
     * @param QueueItemInterface $queueItem
     */
    public function dequeue(QueueItemInterface $queueItem);

    /**
     * @param QueueItemInterface $queueItem
     * @return bool
     */
    public function has(QueueItemInterface $queueItem): bool;

    /**
     * @return void
     */
    public function clear();

    /**
     * @return QueueItemInterface[]
     */
    public function toArray(): array;
}
