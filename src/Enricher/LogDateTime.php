<?php

declare(strict_types=1);

namespace JardisCore\Logger\Enricher;

use DateTime;
use JardisCore\Logger\Contract\LogEnricherInterface;

/**
 * This class implements the LogEnricherInterface.
 * It provides a callable implementation to retrieve the current date and time.
 */
class LogDateTime implements LogEnricherInterface
{
    /**
     * Invokes the object as a function and returns the current date and time in 'Y-m-d H:i:s' format.
     *
     * @return string The formatted date and time.
     */
    public function __invoke(): string
    {
        return (new DateTime())->format('Y-m-d H:i:s');
    }
}
