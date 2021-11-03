<?php

//********************* 日付ランダム生成 **************************
// argv[0] 生成数
// argv[1] 出力フォーマット
$argv = ['9', 'Ymd'];
date_default_timezone_set('UTC');
$start = strtotime('1970-01-01 00:00:00'); // 0
$end = strtotime('2038-01-19 03:14:07'); // 2147483647
for ($i = 0; $i < $argv[0]; $i++) {
    $release_d[] = date($argv[1], mt_rand($start, $end));
    $purchase_d[] = date($argv[1], mt_rand($start, $end));
}
//********************* volume price ランダム生成**************************
for ($i = 0; $i < 9; $i++) {
    $volume[] = rand(1, 10);
    $price[] = rand(10, 60) * 10;
}
//********************* 文字列 ランダム生成 **************************
for ($i = 0; $i < 9; $i++) {
    $title[] = chr(mt_rand(65, 90)) . chr(mt_rand(65, 90)) . chr(mt_rand(65, 90)) .
        chr(mt_rand(65, 90)) . chr(mt_rand(65, 90)) . chr(mt_rand(65, 90));
}

$data = [
    $title, $volume, $price, $release_d, $purchase_d
];
echo '$data:';
var_dump($data);
echo '<br>';
