<?php

namespace Rubix\ML\Other\Loggers;

use Psr\Log\LogLevel;

/**
 * Black Hole
 *
 * A logger that sends messages straight into a super-massive black hole.
 *
 * @category    Machine Learning
 * @package     Rubix/ML
 * @author      Andrew DalPino
 */
class BlackHole extends Logger
{
    /**
     * Logs with an arbitrary level.
     *
     * @param  mixed  $level
     * @param  string  $message
     * @param  array  $context
     * @return void
     */
    public function log($level, $message, array $context = []) : void
    {
        // ⬤
    }
}
