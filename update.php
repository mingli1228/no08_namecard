<?php
// DB接続
try {
    $pdo = new PDO('mysql:host=localhost;dbname=db_namecard;charset=utf8', 'root', '');
} catch (PDOException $e) {
    exit('DB接続失敗: ' . $e->getMessage());
}

// POSTデータの取得
$id = $_POST['id'] ?? null;
$name = $_POST['name'] ?? '';
$reading = $_POST['reading'] ?? '';
$company = $_POST['company'] ?? '';
$date = $_POST['date'] ?? null;
$note = $_POST['note'] ?? '';
$twitter = $_POST['twitter'] ?? '';
$facebook = $_POST['facebook'] ?? '';
$note_id = $_POST['note_id'] ?? '';

// バリデーション（最低限）
if (!$id || !is_numeric($id)) {
    exit('無効なIDです');
}

// SQL更新処理
$sql = "UPDATE db_namecard SET 
            name = :name,
            reading = :reading,
            company = :company,
            date = :date,
            note = :note,
            twitter = :twitter,
            facebook = :facebook,
            note_id = :note_id,
            updated_at = NOW()
        WHERE id = :id";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':name', $name);
$stmt->bindValue(':reading', $reading);
$stmt->bindValue(':company', $company);
$stmt->bindValue(':date', $date);
$stmt->bindValue(':note', $note);
$stmt->bindValue(':twitter', $twitter);
$stmt->bindValue(':facebook', $facebook);
$stmt->bindValue(':note_id', $note_id);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);

$status = $stmt->execute();

if ($status) {
    header("Location: index.php?status=registered");
    exit;
} else {
    echo "更新に失敗しました。<br>";
    $error = $stmt->errorInfo();
    echo "<pre>" . print_r($error, true) . "</pre>";
}
