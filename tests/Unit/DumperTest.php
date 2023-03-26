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

    expect($highlighted)->toBe('[37m[[0m
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
[37m][0m');
});

test('Highlighter with unknown type', function () {
    $highlighted = Dumper::highlight(fopen('php://memory', 'r'));

    expect($highlighted)->toContain('Resource id #');
});

test('Dump function dumps using var_dump', function () {
    ob_start();
    $array = ['foo' => 'bar'];
    dump($array);
    expect(ob_get_clean())->toBe('array(1) {
  ["foo"]=>
  string(3) "bar"
}
');
});

test('Dump function dumps using formatter when option is set', function () {
    ob_start();
    $array = ['foo' => 'bar'];
    dump($array, true);
    expect(ob_get_clean())->toBe(Dumper::highlight($array)."\n");
});
