<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once('funcs.php');
$pdo = db_conn();

$name = $_POST['name'] ?? '';
$reading = $_POST['reading'] ?? '';
$company = $_POST['company'] ?? '';
$date = $_POST['date'] ?? null;
$note = $_POST['note'] ?? '';
$twitter = $_POST['twitter'] ?? '';
$facebook = $_POST['facebook'] ?? '';
$note_id = $_POST['note_id'] ?? '';

$sql = "INSERT INTO db_namecard (name, reading, company, date, note, twitter, facebook, note_id)
        VALUES (:name, :reading, :company, :date, :note, :twitter, :facebook, :note_id)";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':name', $name);
$stmt->bindValue(':reading', $reading);
$stmt->bindValue(':company', $company);
$stmt->bindValue(':date', $date);
$stmt->bindValue(':note', $note);
$stmt->bindValue(':twitter', $twitter);
$stmt->bindValue(':facebook', $facebook);
$stmt->bindValue(':note_id', $note_id);

$status = $stmt->execute();

if ($status) {
    header("Location: index.php?status=registered");
    exit;
} else {
    echo "登録に失敗しました。<br>";
    $error = $stmt->errorInfo();
    echo "<pre>" . print_r($error, true) . "</pre>";
}
