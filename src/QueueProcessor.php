<?php
/**
 * Copyright 2019 The WildPHP Team
 *
 * You should have received a copy of the MIT license with the project.
 * See the LICENSE file for more information.
 */

declare(strict_types=1);

namespace WildPHP\Queue;

use React\EventLoop\LoopInterface;

/**
 * Class QueueProcessor
 * @package WildPHP\Core\Queue
 */
class QueueProcessor
{
    /**
     * @var QueueInterface
     */
    private $queue;

    /**
     * The amount of messages allowed per burst.
     * @var int
     */
    private $burstAmount = 5;

    /**
     * The amount of messages after which to trigger a burst.
     * @var int
     */
    private $burstTrigger = 3;

    /**
     * The state of the burst mode. Do not change.
     * @var bool
     */
    private $usedBurst = false;

    /**
     * The amount of messages to send per second.
     * Note that this value does *not* apply to burst mode.
     * @var int
     */
    private $messagesPerSecond = 1;

    /**
     * The interval (per second) at which to run the processor.
     * @var int
     */
    private $interval = 1;

    /**
     * QueueProcessor constructor.
     * @param QueueInterface $queue
     * @param LoopInterface $loop
     */
    public function __construct(QueueInterface $queue, LoopInterface $loop)
    {
        $loop->addPeriodicTimer($this->interval, [$this, 'processDueItems']);
        $this->queue = $queue;
    }

    /**
     * @param int $totalItemCount
     * @return bool
     */
    public function shouldUseBurst(int $totalItemCount): bool
    {
        return !$this->usedBurst && $totalItemCount > $this->burstTrigger;
    }

    /**
     * @return void
     * @throws QueueException
     */
    public function processDueItems(): void
    {
        $items = $this->queue->toArray();

        $this->usedBurst = $this->shouldUseBurst(count($items));
        $amount = $this->usedBurst() ? $this->burstAmount : $this->messagesPerSecond;

        $itemsToProcess = array_slice($items, 0, $amount);

        foreach ($itemsToProcess as $queueItem) {
            $queueItem->getDeferred()->resolve($queueItem);
            $this->queue->remove($queueItem);
        }

        // Reset the burst flag when the queue is now empty
        if ($this->usedBurst && count($this->queue->toArray()) === 0) {
            $this->usedBurst = false;
        }
    }

    /**
     * @return bool
     */
    public function usedBurst(): bool
    {
        return $this->usedBurst;
    }
}
