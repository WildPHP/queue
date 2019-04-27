<?php
/**
 * Copyright 2019 The WildPHP Team
 *
 * You should have received a copy of the MIT license with the project.
 * See the LICENSE file for more information.
 */

declare(strict_types=1);

namespace WildPHP\Queue;

class CallbackQueueItem extends BaseQueueItem
{
    /**
     * CallableQueueItem constructor.
     * @param callable $onSuccess
     * @param callable|null $onFailure
     */
    public function __construct(callable $onSuccess, callable $onFailure = null)
    {
        parent::__construct();

        $this->getPromise()->then(static function () use ($onSuccess) {
            $onSuccess();
        }, static function () use ($onFailure) {
            $onFailure();
        });
    }
}
