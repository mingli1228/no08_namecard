<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once('funcs.php');
$pdo = db_conn();

// データ取得
$sql = "SELECT * FROM db_namecard ORDER BY created_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$cards = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>名刺一覧</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* 仮の見た目（後でCSSで置き換えてOK） */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #aaa;
            padding: 8px;
            text-align: left;
        }

        .delete-btn {
            background-color: #ff4d4d;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }

        .delete-btn:hover {
            background-color: #cc0000;
        }
    </style>
</head>

<body>

    <h1>名刺一覧</h1>
    <a href="index.php">← 戻る</a>

    <table id="namecard-table">
        <thead>
            <tr>
                <th>名前</th>
                <th>読み方</th>
                <th>会社名</th>
                <th>登録日</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cards as $card): ?>
                <tr class="namecard-row" data-id="<?= htmlspecialchars($card['id']) ?>">
                    <td class="name"><?= htmlspecialchars($card['name']) ?></td>
                    <td class="reading"><?= htmlspecialchars($card['reading']) ?></td>
                    <td class="company"><?= htmlspecialchars($card['company']) ?></td>
                    <td class="created-at"><?= htmlspecialchars($card['created_at']) ?></td>
                    <td>
                        <form method="POST" action="delete.php" class="delete-form" onsubmit="return confirm('削除してもよろしいですか？');">
                            <input type="hidden" name="id" value="<?= $card['id'] ?>">
                            <button type="submit" class="delete-btn">×</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>

</html>