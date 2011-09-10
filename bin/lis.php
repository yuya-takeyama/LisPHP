#!/usr/bin/env php
<?php
set_include_path(__DIR__ . '/../src' . PATH_SEPARATOR . get_include_path());

require_once 'LisPHP.php';

echo "Welcome to REPL for LisPHP!", PHP_EOL,
     "Input your LisPHP code and press Ctrl+D to evaluate it.", PHP_EOL, PHP_EOL;

$lisphp = new LisPHP;

if (isset($argv[1])) {
    $exp = file_get_contents($argv[1]);
    eval("\$lisphp->evaluate({$exp});");
} else {
    while (true) {
        echo "lis.php > ";
        $exp = file_get_contents('php://stdin');
        $exp = chop($exp);
        eval("\$result = \$lisphp->evaluate({$exp});");
        if ($result instanceof Closure) {
            echo "<#Lambda>", PHP_EOL;
        } else {
            var_dump($result);
        }
    }
}
