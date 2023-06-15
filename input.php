<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="sample.css">
  <title>超音波画像相談（入力BOX）</title>
</head>

<body>
  <form action="create.php"  method="POST">
    <fieldset>
      <legend>超音波画像相談（入力画面）</legend>
      <a href="read.php">一覧へ飛びます！</a>
      <div>
        <!-- todo: <input type="text" name="todo"> -->
        臓器: <input type="text" name="todo">
      </div>
      <div>
        <!-- todo: <input type="text" name="todo"> -->
        聞きたい事: <input type="text" name="todo2">
      </div>
      <div>
        希望期日: <input type="date" name="deadline">
      </div>

      <!-- <div>
        貼付画像: <input image="img" name="tmg">
      </div> -->
      <div>
        <button>送信</button>
      </div>
    </fieldset>
  </form>

</body>

</html>
