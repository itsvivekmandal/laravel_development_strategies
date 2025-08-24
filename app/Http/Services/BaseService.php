<?php

namespace App\Http\Services;

use Psr\Log\LoggerInterface;

abstract class BaseService
{
    protected LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
}
