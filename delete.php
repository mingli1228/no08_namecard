<?php
// DB接続
try {
    $pdo = new PDO('mysql:host=localhost;dbname=db_namecard;charset=utf8', 'root', '');
} catch (PDOException $e) {
    exit('DB接続失敗: ' . $e->getMessage());
}

// POSTでIDを受け取る
$id = $_POST['id'] ?? null;

if ($id !== null && is_numeric($id)) {
    $stmt = $pdo->prepare("DELETE FROM db_namecard WHERE id = :id");
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
}

// 削除完了後にindex.phpに戻す（フラッシュ付き）
header("Location: index.php?status=deleted");
exit;
