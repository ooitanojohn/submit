<?php
//********************* sql接続 **************************
// DB configの階層を指定
require_once '../../const.php';
$dsn = 'mysql:dbname=' . DB_NAME . ';host=' . HOST . ';charset=utf8';
// configに各定数を記述
try {
    $link = new PDO($dsn, USER_ID, PASSWORD);
}
// DB接続失敗
catch (PDOException $err) {
    // エラー内容
    exit('DB接続エラー:' . $err->getMessage());
}

// max min 日付初期値
date_default_timezone_set('UTC');
$start = strtotime('1970-01-01 00:00:00'); // 0
$end = strtotime('2038-01-19 03:14:07'); // 2147483647
for ($i = 0; $i < 10; $i++) {
    // 各テストデータランダム生成
    $title = chr(mt_rand(65, 90)) . chr(mt_rand(65, 90)) . chr(mt_rand(65, 90)) . chr(mt_rand(65, 90)) . chr(mt_rand(65, 90)) . chr(mt_rand(65, 90));
    $volume = rand(1, 10);
    $price = rand(10, 60) * 10;
    $release_d = date('Ymd', mt_rand($start, $end));
    $purchase_d = date('Ymd', mt_rand($start, $end));
    // クエリ実行
    $sql = "INSERT INTO m_book (title,volume,price,release_date,purchase_date)
            VALUES(
            :title,
            :volume,
            :price,
            :release_d,
            :purchase_d
            )";
    $data = $link->prepare($sql);
    $data->bindValue(':title', $title, PDO::PARAM_STR);
    $data->bindValue(':volume', $volume, PDO::PARAM_INT);
    $data->bindValue(':price', $price, PDO::PARAM_INT);
    $data->bindValue(':release_d', $release_d, PDO::PARAM_STR);
    $data->bindValue(':purchase_d', $purchase_d, PDO::PARAM_STR);
    $data->execute();
}
