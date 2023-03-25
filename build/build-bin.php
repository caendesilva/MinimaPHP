<?php

require_once __DIR__.'/../minima.php';

$exitCode = Command::main(function (): void {
    $this->info('Building binary!');

    $src = file_get_contents(__DIR__.'/../minima.php');
    $base = file_get_contents(__DIR__.'/dev-bin');

    $src = str_replace("<?php", "// start minima.php", $src);
    $bin = str_replace("require_once __DIR__.'/../minima.php';", $src . "\n// end minima.php", $base);

    $shortSha = trim(shell_exec('git rev-parse --short HEAD'));
    $bin = str_replace("const REVISION = 'dev'", "const REVISION = '$shortSha'", $bin);

    file_put_contents(__DIR__.'/../bin/minima', $bin);

    $this->info('All done!');
});

exit($exitCode);
