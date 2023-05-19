<?php

declare(strict_types=1);

$n = $i = 5;

while ($i--) {
    echo str_repeat(' ', $i).str_repeat('* ', $n - $i)."\n";
}