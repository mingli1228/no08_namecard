<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>新規登録 | 名刺管理アプリ</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <div class="container">
        <h1>名刺情報の新規登録</h1>
        <a href="index.php" class="btn btn-secondary">← 一覧に戻る</a>

        <form action="insert.php" method="POST" class="form">

            <div class="form-group">
                <label>名前<span class="required">*</span></label>
                <input type="text" name="name" required>
            </div>

            <div class="form-group">
                <label>読み方</label>
                <input type="text" name="reading">
            </div>

            <div class="form-group">
                <label>会社名</label>
                <input type="text" name="company">
            </div>

            <div class="form-group">
                <label>会った日付</label>
                <input type="date" name="date">
            </div>

            <div class="form-group">
                <label>特記事項・メモ</label>
                <textarea name="note" rows="4"></textarea>
            </div>

            <div class="form-group">
                <label>Twitter ID</label>
                <input type="text" name="twitter">
            </div>

            <div class="form-group">
                <label>Facebook ID</label>
                <input type="text" name="facebook">
            </div>

            <div class="form-group">
                <label>note ID</label>
                <input type="text" name="note_id">
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">登録する</button>
            </div>

        </form>
    </div>

</body>

</html>