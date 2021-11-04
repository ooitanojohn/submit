<?php
///********************************************************
// paging
//********************************************************
session_start();
//********************* 設定 **************************
// page内の配列要素数
$show = 5;
//********************* 初期化 **************************
// table tr値
$tableIndex = [
    'タイトル', '巻数', '値段', '発売日', '購入日'
];
// 検索値,sql文実行するか,検索値アリか
$title = '';
$sqlExe = false;
$sqlSearch = false;
// 現在のページ番号
if (isset($_GET['page'])) {
    $nowPage = $_GET['page'];
    $nowPageElement = $nowPage * $show;
} else {
    // page 初期化
    $nowPage = 0;
    $nowPageElement = 0;
}
//********************* topに戻る際 cookie消す **************************
if (isset($_GET['reset']) && $_GET['reset'] == 'on') {
    setcookie("search", "", time() - 100);
    header('Location:index.php?reset=off');
    exit;
}
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

//********************************************************
//  検索値あり(sql文準備),なし,初回(sql文準備)
//********************************************************
if (isset($_POST['search']) || isset($_COOKIE['search'])) {
    //********************* 検索値無し **************************
    if (isset($_POST['search']) && $_POST['title'] == '') {
        // 表示内容 , 残った検索値
        $nowPageElement = [
            []
        ];
        setcookie("search", "", time() - 100);
    }
    //********************* 検索中 **************************
    else {
        if (isset($_COOKIE['search'])) {
            $title = $_COOKIE['search'];
        }
        if (isset($_POST['title'])) {
            $title = $_POST['title'];
        }
        // 検索値アリのsql文
        $sql = "SELECT * FROM m_book
        WHERE del_date IS NULL AND title LIKE :postTitle
        ORDER BY purchase_date DESC
        LIMIT :start,:num";
        // sqlインジェクション
        $data = $link->prepare($sql);
        $data->bindValue(':postTitle', "%{$title}%", PDO::PARAM_STR);
        // cookieに検索値保存 前の値がある場合削除
        setcookie("search", "", time() - 100);
        setcookie("search", $title);
        // 実行状況値
        $sqlExe = true;
        $sqlSearch = true;
    }
}
//********************* ページ初見時 全件検索,ページリンクレコードMAX**************************
else {
    $sql = "SELECT * FROM m_book
    WHERE del_date IS NULL
    ORDER BY purchase_date DESC
    LIMIT :start,:num";
    // sqlインジェクション
    $data = $link->prepare($sql);
    $sqlExe = true;
}

//********************* sql文ありの場合 クエリ実行 **************************
if ($sqlExe === true) {
    $data->bindValue(':start', $nowPageElement, PDO::PARAM_INT);
    $data->bindValue(':num', $show, PDO::PARAM_INT);
    // クエリ実行
    $data->execute();
    $nowPageElement = $data->fetchAll(PDO::FETCH_NAMED);
    // *** 現在のページの要素 ***
    foreach ($nowPageElement as $key => $val) {
        unset($nowPageElement[$key]['id']);
        unset($nowPageElement[$key]['del_date']);
    }

    //********************* 下部リンクの為の最大ページ数 **************************
    //検索値あり || 初回 でsql文割り振り
    if ($sqlSearch === true) {
        $sql = "SELECT count(*) FROM m_book
        WHERE del_date IS NULL AND title LIKE :postTitle";
        $max = $link->prepare($sql);
        $max->execute(array(':postTitle' => "%{$title}%"));
    } elseif ($sqlExe === true) {
        $max = $link->query("select count(*) from m_book");
    }
    $userList = $max->fetch(PDO::FETCH_ASSOC);
    $userList = intval($userList['count(*)']);
}
//********************* リンク表示 on off **************************
// *** pageLink初期化 ***
$top = '';
$last = '';
// a 検索値なし&&検索結果なし || b 検索値アリ,初回
// a リンクを非表示
if ($sqlExe === false || empty($nowPageElement[0])) {
    $top = 'none';
    $last = 'none';
    $pageLinkNum[] = 'none';
}
// b リンクを表示
else {
    // 最大ページ求める
    if ($userList % $show === 0) {
        $maxPage = intval($userList / $show) - 1;
    } else {
        $maxPage = intval($userList / $show);
    }
    // *** 最初のページ ***
    if ($nowPage == 0) {
        $top = 'none';
    }
    // *** 最後のページ ***
    if ($nowPage == $maxPage) {
        $last = 'none';
    }
    // *** 現在のページ ***
    for ($i = 0; $i < $maxPage + 1; $i++) {
        if ($i  == $nowPage) {
            $pageLinkNum[] = 'none';
        } else {
            $pageLinkNum[] = '';
        }
    }
}
require_once 'view/index.php';

// DB接続子 停止
$link = NULL;
