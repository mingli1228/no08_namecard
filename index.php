<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// DB接続
try {
    $pdo = new PDO('mysql:host=localhost;dbname=db_namecard;charset=utf8', 'root', '');
} catch (PDOException $e) {
    exit('DB接続失敗: ' . $e->getMessage());
}

// --- フラッシュメッセージ処理 ---
$flash = $_GET['status'] ?? null;
$message = '';
if ($flash === 'registered') $message = '登録しました。';
if ($flash === 'deleted')    $message = '削除しました。';

// --- 並び順設定（デフォルト: updated_at） ---
$order = $_GET['order'] ?? 'updated_at';
switch ($order) {
    case 'name_asc':
        $order_by = 'name ASC';
        break;
    case 'created_at':
        $order_by = 'created_at DESC';
        break;
    default:
        $order_by = 'updated_at DESC';
}

// --- 検索処理（名前・会社名） ---
$keyword = $_GET['keyword'] ?? '';
$search_sql = '';
$params = [];

if ($keyword !== '') {
    $search_sql = "WHERE name LIKE :kw OR company LIKE :kw";
    $params[':kw'] = '%' . $keyword . '%';
}

// --- データ取得 ---
$sql = "SELECT * FROM db_namecard $search_sql ORDER BY $order_by";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>名刺管理アプリ</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <div class="container">

        <header>
            <h1>名刺に書けないことを記録しよう</h1>
            <a href="register.php" class="btn btn-primary">＋ 新規登録</a>
        </header>

        <?php if ($message): ?>
            <div class="flash-message"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <section class="controls">
            <form method="GET" class="search-form">
                <input type="text" name="keyword" placeholder="名前や会社名で検索" value="<?= htmlspecialchars($keyword) ?>">
                <select name="order">
                    <option value="updated_at" <?= $order === 'updated_at' ? 'selected' : '' ?>>最終更新日順</option>
                    <option value="name_asc" <?= $order === 'name_asc' ? 'selected' : '' ?>>あいうえお順</option>
                    <option value="created_at" <?= $order === 'created_at' ? 'selected' : '' ?>>登録日順</option>
                </select>
                <button type="submit" class="btn">並び替え・検索</button>
            </form>
        </section>

        <table class="data-table">
            <thead>
                <tr>
                    <th>名前</th>
                    <th>読み方</th>
                    <th>会社名</th>
                    <th>登録日時</th>
                    <th>最終更新</th>
                    <th>削除</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($results) === 0): ?>
                    <tr>
                        <td colspan="6" class="no-data">該当するデータがありません</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($results as $row): ?>
                        <tr class="row-link" onclick="location.href='edit.php?id=<?= $row['id'] ?>';">
                            <td><?= htmlspecialchars($row['name']) ?></td>
                            <td><?= htmlspecialchars($row['reading']) ?></td>
                            <td><?= htmlspecialchars($row['company']) ?></td>
                            <td><?= htmlspecialchars($row['created_at']) ?></td>
                            <td><?= htmlspecialchars($row['updated_at']) ?></td>
                            <td>
                                <form method="POST" action="delete.php" onsubmit="return confirm('本当に削除しますか？');">
                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                    <button type="submit" class="btn btn-danger">×</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

    </div>

</body>

</html>