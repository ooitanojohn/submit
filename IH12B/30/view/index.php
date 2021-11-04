<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* 初期化*/
        li {
            list-style: none;
        }

        /* レイアウト*/
        body {
            text-align: center;
            height: fit-content;
        }

        table {
            margin: 0 auto;
        }

        a {
            margin-right: 5px;
        }

        form,
        summary,
        table {
            margin-bottom: 10px;
        }

        /* ページング用*/
        .none {
            display: none;
        }
    </style>
</head>

<body>
    <h1>課題 no.1 ページャ</h1>
    <form method='post'>
        <input type="text" name="title">
        <button type="submit" name="search">検索</button>
    </form>
    <table border=1>
        <summary><a href="index.php?reset=on">漫画DB TOPへ</a></summary>
        <tr>
            <?php foreach ($tableIndex as $val) { ?>
                <td><?php echo $val ?></td>
            <?php } ?>
        </tr>
        <?php foreach ($nowPageElement as $user) : ?>
            <tr>
                <?php foreach ($user as $val) { ?>
                    <td><?php echo $val ?></td>
                <?php } ?>
            </tr>
        <?php endforeach; ?>
    </table>
    <li>
        <a href=" index.php?<?php echo 'page=' . $nowPage - 1 ?>" class="<?php echo $top ?>">前へ</a>
        <?php foreach ($pageLinkNum as $key => $val) { ?>
            <a href="index.php?<?php echo 'page=' . $key ?>" class="<?php echo $val ?>"><?php echo $key ?></a>
        <?php } ?>
        <a href="index.php?<?php echo 'page=' . $nowPage + 1 ?>" class="<?php echo $last ?>">次へ</a>
    </li>
</body>

</html>