<?php

require_once 'minima.php';

Command::main(function (): void {
    $runTasks = $this->hasOption('skip-tasks');

    $this->formatted('<info>Tasks example</info> - <yellow>pass `--no-tasks` to skip the tasks</yellow>');

    //
});
