<?php

declare(strict_types=1);

namespace JardisCore\Logger\Contract;

interface LogFormatInterface
{
    /**
     * @param array<int|string, mixed> $logData
     * @return string
     */
    public function __invoke(array $logData): string;
}
