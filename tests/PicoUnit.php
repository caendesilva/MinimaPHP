<?php

declare(strict_types=1);

final class PicoUnit
{
    private const PASSED = "\033[32m".'passed'."\033[0m";
    private const FAILED = "\033[31m".'failed'."\033[0m";

    public static string $startMessage = "%sRunning tests for %s%s\n\n";

    private static self $instance;
    private float $startTime;
    private array $contents;
    private int $exitCode;

    private function __construct(string $file)
    {
        $this->startTime = microtime(true);
        $this->contents = file($file);
        $this->exitCode = 0;
    }

    public static function boot(string $file): void
    {
        echo sprintf(self::$startMessage, ANSI::GREEN, basename(dirname($file)), ANSI::RESET);

        self::$instance = new self($file);
    }

    public static function stop(): int
    {
        $stopTimeInMs = number_format((microtime(true) - self::getInstance()->startTime) * 1000, 2);
        echo sprintf("\n%sTests completed in %s with exit code %d %s\n", ANSI::GREEN, $stopTimeInMs . 'ms', self::getInstance()->exitCode, ANSI::RESET);

        return self::getInstance()->exitCode;
    }

    private static function getInstance(): self
    {
        return self::$instance;
    }

    public static function test(bool|Closure $result): void
    {
        $line = trim(self::getInstance()->contents[debug_backtrace()[1]['line'] - 1]);
        $testName = substr($line, 5, strpos($line, ');') - 5);

        if ($result instanceof Closure) {
            $result = $result();
        }

        if (! $result) {
            self::getInstance()->exitCode = 1;
        }

        echo ($result ? self::PASSED : self::FAILED) . ": $testName\n";
    }
}

function test(bool|Closure $result): void
{
    PicoUnit::test($result);
}
