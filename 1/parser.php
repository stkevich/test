<?php

function getSumByDir(string $dir): int {
    $sum = 0;
    $arrDir = scandir($dir);
    foreach ($arrDir as $key => $value) {
        if ($value != '.' && $value != '..') {
            if (is_dir($dir . DIRECTORY_SEPARATOR . $value)) {
                $sum += getSumByDir($dir . DIRECTORY_SEPARATOR . $value);
            }
            elseif ($value == 'count') {
                $sum += (int)file_get_contents($dir . DIRECTORY_SEPARATOR . $value);
            }
        }
    }
    return $sum;
}

$sum = getSumByDir(__DIR__);
print sprintf("Sum in current dir: %d", $sum);
