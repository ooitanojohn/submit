<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        a {
            padding-right: 5px;
        }

        a.none {
            display: none;
        }

        tr.none {
            display: none;
        }
    </style>
</head>

<body>
    <form method='post'>
        <input type="text" name="title">
        <button type="submit" name="search">検索</button>
    </form>
    <table border=1>
        <summary><a href="index.php">漫画DB TOPへ</a></summary>
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
    <a href=" index.php?<?php echo 'page=' . $nowPage - 1 ?>" class="<?php echo $top ?>">前へ</a>
    <?php foreach ($pageLinkNum as $key => $val) : ?>
        <a href="index.php?<?php echo 'page=' . $key ?>" class="<?php echo $val ?>"><?php echo $key ?></a>
    <?php endforeach; ?>
    <a href="index.php?<?php echo 'page=' . $nowPage + 1 ?>" class="<?php echo $last ?>">次へ</a>
</body>

</html>