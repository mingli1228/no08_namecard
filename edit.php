<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once('funcs.php');
$pdo = db_conn();

$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
    exit('無効なIDです');
}

$stmt = $pdo->prepare("SELECT * FROM db_namecard WHERE id = :id");
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row) {
    exit('該当データが見つかりませんでした');
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>編集 | 名刺管理アプリ</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <div class="container">
        <h1>名刺情報の編集</h1>
        <a href="index.php" class="btn btn-secondary">← 一覧に戻る</a>

        <form action="update.php" method="POST" class="form">
            <input type="hidden" name="id" value="<?= htmlspecialchars($row['id']) ?>">

            <div class="form-group">
                <label>名前<span class="required">*</span></label>
                <input type="text" name="name" value="<?= htmlspecialchars($row['name']) ?>" required>
            </div>

            <div class="form-group">
                <label>読み方</label>
                <input type="text" name="reading" value="<?= htmlspecialchars($row['reading']) ?>">
            </div>

            <div class="form-group">
                <label>会社名</label>
                <input type="text" name="company" value="<?= htmlspecialchars($row['company']) ?>">
            </div>

            <div class="form-group">
                <label>会った日付</label>
                <input type="date" name="date" value="<?= htmlspecialchars($row['date']) ?>">
            </div>

            <div class="form-group">
                <label>特記事項・メモ</label>
                <textarea name="note" rows="4"><?= htmlspecialchars($row['note']) ?></textarea>
            </div>

            <div class="form-group">
                <label>Twitter ID</label>
                <input type="text" name="twitter" value="<?= htmlspecialchars($row['twitter']) ?>">
            </div>

            <div class="form-group">
                <label>Facebook ID</label>
                <input type="text" name="facebook" value="<?= htmlspecialchars($row['facebook']) ?>">
            </div>

            <div class="form-group">
                <label>note ID</label>
                <input type="text" name="note_id" value="<?= htmlspecialchars($row['note_id']) ?>">
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">保存する</button>
            </div>
        </form>
    </div>

</body>

</html>