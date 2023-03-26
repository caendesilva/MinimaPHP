<?php

require_once __DIR__.'/../minima.php';

final class PicoUnit
{
    private const PASSED = "\033[32m".'passed'."\033[0m";
    private const FAILED = "\033[31m".'failed'."\033[0m";

    public static string $startMessage = "Running tests for %s\n\n";

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
        echo sprintf(ANSI::GREEN.self::$startMessage.ANSI::RESET, basename(dirname($file)));

        self::$instance = new self($file);
    }

    public static function stop(): int
    {
        $stopTimeInMs = number_format((microtime(true) - self::getInstance()->startTime) * 1000, 2);
        echo sprintf("\n%sTests completed in %s with exit code %d %s\n", ANSI::GREEN, $stopTimeInMs.'ms', self::getInstance()->exitCode, ANSI::RESET);

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

        if (!$result) {
            self::getInstance()->exitCode = 1;
        }

        echo($result ? self::PASSED : self::FAILED).": $testName\n";
    }
}

function test(bool|Closure $result): void
{
    PicoUnit::test($result);
}

use PicoUnit as TestCase;

TestCase::$startMessage = "Running unit tests!\n";

TestCase::boot(__FILE__);

Command::main(function () {
    $this->formatted("\n<warning>ANSI Colours:</warning>");

    $this->line('---------');
    // $this->line('Base ANSI');
    $this->line(ANSI::BLACK.'BLACK'.ANSI::RESET);
    $this->line(ANSI::RED.'RED'.ANSI::RESET);
    $this->line(ANSI::GREEN.'GREEN'.ANSI::RESET);
    $this->line(ANSI::YELLOW.'YELLOW'.ANSI::RESET);
    $this->line(ANSI::BLUE.'BLUE'.ANSI::RESET);
    $this->line(ANSI::MAGENTA.'MAGENTA'.ANSI::RESET);
    $this->line(ANSI::CYAN.'CYAN'.ANSI::RESET);
    $this->line(ANSI::WHITE.'WHITE'.ANSI::RESET);
    $this->line(ANSI::GRAY.'GRAY'.ANSI::RESET);
    $this->line(ANSI::RESET.'RESET'.ANSI::RESET);

    // $this->line('Extended ANSI');
    $this->line(ANSI_EXT::BRIGHT_RED.'BRIGHT_RED'.ANSI::RESET);
    $this->line(ANSI_EXT::BRIGHT_GREEN.'BRIGHT_GREEN'.ANSI::RESET);
    $this->line(ANSI_EXT::BRIGHT_YELLOW.'BRIGHT_YELLOW'.ANSI::RESET);
    $this->line(ANSI_EXT::BRIGHT_BLUE.'BRIGHT_BLUE'.ANSI::RESET);
    $this->line(ANSI_EXT::BRIGHT_MAGENTA.'BRIGHT_MAGENTA'.ANSI::RESET);
    $this->line(ANSI_EXT::BRIGHT_CYAN.'BRIGHT_CYAN'.ANSI::RESET);
    $this->line(ANSI_EXT::BRIGHT_WHITE.'BRIGHT_WHITE'.ANSI::RESET);

    // $this->line('XML ANSI');
    $this->line(XML_ANSI::INFO.'INFO'.ANSI::RESET);
    $this->line(XML_ANSI::WARNING.'WARNING'.ANSI::RESET);
    $this->line(XML_ANSI::ERROR.'ERROR'.ANSI::RESET);
    $this->line(XML_ANSI::COMMENT.'COMMENT'.ANSI::RESET);
    $this->line(XML_ANSI::RESET.'RESET'.ANSI::RESET);

    // $this->line('Fluent methods');
    $this->line('line');
    $this->info('info');
    $this->warning('warning');
    $this->error('error');
    $this->line('---------');
});

Command::main(function () {
    $this->formatted("\n<warning>Testing: ANSI Interface</warning>");

    test(ANSI::BLACK === "\033[30m");
    test(ANSI::RED === "\033[31m");
    test(ANSI::GREEN === "\033[32m");
    test(ANSI::YELLOW === "\033[33m");
    test(ANSI::BLUE === "\033[34m");
    test(ANSI::MAGENTA === "\033[35m");
    test(ANSI::CYAN === "\033[36m");
    test(ANSI::WHITE === "\033[37m");
    test(ANSI::GRAY === "\033[90m");
    test(ANSI::RESET === "\033[0m");
});

Command::main(function () {
    $this->formatted("\n<warning>Testing: XML_ANSI Interface</warning>");

    test(XML_ANSI::INFO === ANSI::GREEN);
    test(XML_ANSI::WARNING === ANSI::YELLOW);
    test(XML_ANSI::ERROR === ANSI::RED);
    test(XML_ANSI::COMMENT === ANSI::GRAY);
    test(XML_ANSI::RESET === ANSI::RESET);
});

Command::main(function () {
    $this->formatted("\n<warning>Testing: WritesToConsole</warning>");

    $this->line('---------');
    $this->write('write');
    $this->line('line');
    $this->info('info');
    $this->warning('warning');
    $this->error('error');
    $this->formatted('formatted:
  <info>info</info>, <warning>warning</warning>, <error>error</error>, <comment>comment</comment>, <reset>reset</reset>,
  <red>red</red>, <green>green</green>, <blue>blue</blue>, <yellow>yellow</yellow>, <magenta>magenta</magenta>, <cyan>cyan</cyan>');
    $this->line('---------');
});

exit(TestCase::stop());
