<?php
// var_dump($_POST);
// exit();

$todo=$_POST["todo"];
$todo2=$_POST["todo2"];
$deadline=$_POST["deadline"];
// $deadtime=$_POST["time"];
// $objDateTime=$_POST["deadline"];
// $objDateTime = now();
// var_dump($deadtime);

// echo date('Y-m-d H:i:s')."<br/>\n";

//  \nは開業
$write_data = "{$deadline}...........................{$todo}..................................{$todo2}\n"; 
// $write_data = "{$deadline} {$todo}{$deadtime}\n"; 

// ファイルを開く（'a'はファイルが無ければ自動的に作ってくれる）
$file = fopen('data/todo.todo2.txt','a');

// ロックをかける(上で開いたファイルに)
flock($file,LOCK_EX);

// ファイルに書き込む(①fileに②write_dataを書き込む)
fwrite($file,$write_data);

// ロックを外す(アンロック)
flock($file,LOCK_UN);

// 最後にファイルを閉じる
fclose($file);

// 入力画面に戻り画面を表示する(Location:〇〇、Locationで〇〇に移動する)
header('Location:input.php');
exit();







