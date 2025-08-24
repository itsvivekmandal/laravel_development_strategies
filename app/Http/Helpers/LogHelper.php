<?php

namespace App\Http\Helpers;

use Illuminate\Support\Facades\Log;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\JsonFormatter;
use Monolog\Formatter\LineFormatter;
use Monolog\Logger;
use Monolog\Level;
use Monolog\Processor\IntrospectionProcessor;

trait LogHelper
{
    private string $channel = 'daily';
    private string $logName = 'laravel';
    private string $path = 'logs';
    // protected $logger;

    /**
     * Initialize logger with a custom filename
     */
    public function setupLogger(string $filename = null): void {
        $this->path = env('LOG_PATH', $this->path);
        $this->logName = $filename ?? $this->logName;

        $logger = Log::channel($this->channel)->getLogger();

        // Choose formatter (default JSON if not passed)
       $formatterClass = match (env('LOG_FORMATTER', 'line')) {
            'json' => JsonFormatter::class ,
            'line' => LineFormatter::class,
       };

        // $formatterClass = $formatterClass ?? JsonFormatter::class;
        $formatter = new $formatterClass();

        // Level
        $levelName = strtoupper(env('LOG_LEVEL', 'debug'));
        $level = Logger::toMonologLevel($levelName);

        // Create handler with custom path
        $handler = new StreamHandler(
            storage_path("{$this->path}/{$this->logName}.log"), $level
        );

        // $logger->setHandlers([ new StreamHandler(storage_path("logs/{$this->logName}.log")) ]);

        // Attach formatter to handler
        $handler->setFormatter($formatter);

        // Add processor for file, line, class, function
        $logger->pushProcessor(new IntrospectionProcessor($level, ['Illuminate\\']));
        // Replace handlers
        $logger->setHandlers([$handler]);

        $this->logger = $logger;
    }

    /**
     * Magic getter – auto initialize logger when $this->logger is accessed
     */
    public function __get($name): ?object {
        if ($name === 'logger') {
            if (! isset($this->logger)) {
                // default: use class name as log filename
                // $shortName = strtolower((new \ReflectionClass($this))->getShortName());
                $this->setupLogger($this->logName);
            }
            return $this->logger;
        }

        return null;
    }
}
