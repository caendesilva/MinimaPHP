<?php

test('The highlighter highlights dumped array', function () {
    $array = [
        'foo',
        'bar'   => 'baz',
        'array' => [
            'some',
            'contents',
            'bool'    => true,
            'integer' => 10,
            'deep'    => ['array'],
        ],
        'object' => new Dumper(),
        'null'   => null,
    ];

    $highlighted = Dumper::highlight($array);

    expect($highlighted)->toBe(('[37m[[0m
  [34m\'[32mfoo[34m\'[0m,
  [34m\'[32mbar[34m\'[0m => [34m\'[32mbaz[34m\'[0m,
  [34m\'[32marray[34m\'[0m => [37m[[0m
    [34m\'[32msome[34m\'[0m,
    [34m\'[32mcontents[34m\'[0m,
    [34m\'[32mbool[34m\'[0m => [31mtrue[0m,
    [34m\'[32minteger[34m\'[0m => [33m10[0m,
    [34m\'[32mdeep[34m\'[0m => [37m[[0m
      [34m\'[32marray[34m\'[0m
    [37m][0m
  [37m][0m,
  [34m\'[32mobject[34m\'[0m => [33mDumper[0m,
  [34m\'[32mnull[34m\'[0m => [31mnull[0m
[37m][0m'));
});