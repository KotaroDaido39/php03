<?php
// エラー表示
ini_set("display_errors", 1);

// 1. DB接続します
include('func.php');
$pdo = db_conn();

// 2. POSTデータ取得
$id = $_POST['id'];

// 3. 現在のブックマーク状態を取得
$sql = "SELECT bookmark FROM qiita_table2 WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute(); // 実行

if ($status == false) {
    $error = $stmt->errorInfo();
    exit("SQLError:".$error[2]);
}

$row = $stmt->fetch(PDO::FETCH_ASSOC);
$currentBookmark = $row['bookmark'];

// 4. ブックマーク状態をトグル
$newBookmark = ($currentBookmark == 1) ? 0 : 1;

// 5. データ更新SQL作成
$sql = "UPDATE qiita_table2 SET bookmark = :bookmark WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':bookmark', $newBookmark, PDO::PARAM_INT);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute(); // 実行

// 6. 更新結果を返す
if ($status == false) {
    echo 'error';
} else {
    echo 'success';
}
?>