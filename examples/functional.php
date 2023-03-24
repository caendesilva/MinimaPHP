<?php

require_once __DIR__ . '/../minima.php';

exit(main(fn () => $this->info('The time is: ' . date('c'))));
