<?php

require_once 'minima.php';

Command::main(function (): void {
    $runTasks = $this->hasOption('skip-tasks');

    $taskMessage = $runTasks ? "remove `--no-tasks` to run the tasks" : "pass `--no-tasks` to skip the tasks";
    $this->formatted("<info>Tasks example</info> - <yellow>$taskMessage</yellow>");

    //
});
