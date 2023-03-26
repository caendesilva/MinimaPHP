<?php

declare(strict_types=1);

require_once __DIR__ . '/../minima.php';

Command::main(function () {
    task('File formatting', function () {
        $glob = glob(__DIR__ . '/../{*,**/*}.*', GLOB_BRACE);
        $files = [];

        foreach ($glob as $file) {
            if (is_file($file)) {
                $files[] = $file;
            }
        }

        foreach ($files as $file) {
            $this->line("Formatting ".basename($file));
            formatFile($file);
        }
    });
});

function formatFile(string $file): void {
    $contents = str_replace("\r\n", "\n", file_get_contents($file));
    $contents = str_replace("\t", "    ", $contents);

    $lines = explode("\n", $contents);

    foreach ($lines as $index => $line) {
        $lines[$index] = rtrim($line);
    }
    file_put_contents($file, implode("\n", $lines));
}
