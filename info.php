<?php

$d1 = date_parse('2017-09-30 20:00:00');
$d2 = date_parse('now');

//print_r($d1);
//print_r($d2);
print_r(date_parse('now'));

echo time() - strtotime('2017-09-26 20:00:00');

echo date('d.m.Y', strtotime('2017-09-26 20:00:00'));

if ($d1 < $d2) {
    echo '$d1 is less than $d2.';
} else if ($d1 == $d2) {
    echo '$d1 is equal to $d2.';
} else {
    echo '$d1 is greater than $d2.';
}
