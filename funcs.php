<?php
function db_conn()
{
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=db_namecard;charset=utf8', 'root', '');
        return $pdo;
    } catch (PDOException $e) {
        exit('DB接続失敗: ' . $e->getMessage());
    }
}
