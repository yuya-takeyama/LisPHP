#!/usr/bin/env php
<?php
set_include_path(__DIR__ . '/../src' . PATH_SEPARATOR . get_include_path());

require_once 'LisPHP.php';

$lisphp = new LisPHP;

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
