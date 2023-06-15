<?php
// 文字列をまとめる変数を用意する
$str='';
// $array=[];

// オープンして
$file=fopen('data/todo.todo2.txt', 'r');
// ロックする
flock($file, LOCK_EX);

if($file){

  while($line = fgets($file)){
  $str .= "<tr><td>{$line}</td></tr>";
  
  // array_push($array,$line);
  }
}
flock($file,LOCK_UN);
// 終わったらfcoleする
fclose($file);

// var_dump($array);
// exit();
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="sample.css">
  <title>超音波画像相談（一覧）</title>
</head>

<body>
  <fieldset>
    <legend>超音波画像相談（一覧画面）</legend>
    <a href="input.php">入力画面</a>
    <table>
      <thead>
    
          <th>日付</th>
          <th>目的臓器</th>
          <th>内容</th>
          <!-- <th><?= $str ?></th> -->
          
          
      
      </thead>
      <tbody>
        <?= $str ?>
        
      </tbody>
    </table>
  </fieldset>

<!-- <script>
    const array=<?= json_encode($array)?>;
    console.log(array);
</script>  -->
</body>

</html>