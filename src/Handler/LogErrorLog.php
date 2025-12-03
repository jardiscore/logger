<?php

declare(strict_types=1);

namespace JardisCore\Logger\Handler;

/**
 * Returns log entries to errorLog
 */
class LogErrorLog extends LogCommand
{
    public function __construct(string $logLevel)
    {
        parent::__construct($logLevel);
        $this->setStream(STDERR);
    }
}
