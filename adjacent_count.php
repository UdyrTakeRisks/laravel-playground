<?php

// Sliding Window approach (two pointers)
function adjacent_count(int $target, int ...$arr): bool
{
    $sum = $start = 0;
    for ($end = 0; $end < count($arr); ++$end) {
        $sum += $arr[$end];
        while ($sum > $target && $start <= $end) {
            $sum -= $arr[$start];
            ++$start;
        }
        if ($sum === $target) {
            return true;
        }
    }
    return false;
}

$arr = [5, 3, 3, 5, 2, 4, 1];
$arr2 = [5, 3, 3, 5, 3, 4, 1];
$target = 10;
    
echo adjacent_count($target, ...$arr) === true ? 'true' . "\n" : 'false' . "\n"; // true
echo adjacent_count($target, ...$arr2) === true ? 'true' . "\n" : 'false' . "\n"; // false
    
/* Tracing */

//     S   E
// 5 3 3 5 2 4 1

// 5 
// 8
// 11
// 6 
// 11
// 8
// 10 done