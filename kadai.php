<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="sample.css">

  <title>超音波画像コメント</title>

  <!-- ** チャートJs************************************************************************************* -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.2.0/chart.min.js"
    integrity="sha512-VMsZqo0ar06BMtg0tPsdgRADvl0kDHpTbugCBBrL55KmucH6hP9zWdLIWY//OTfMnzz6xWQRxQqsUFefwHuHyg=="
    crossorigin="anonymous"></script>
  <script
    src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns@next/dist/chartjs-adapter-date-fns.bundle.min.js"></script>

</head>

<body>
  <div class="video-container">
    <video autoplay loop muted preload width="350" height="280">
      <source src="HCC.mp4" type="video/mp4">
  </div>
  <h1>超音波画像コメント</h1>

  <br>
  <br>
  <br>

  <!-- 入力画面 -->
  <form>
    <fieldset>
      <legend>スマホに提示された画像へのコメントをお願いします</legend>

      <div class="flex-container1">
        <div class="flex-item1">
          氏名: <input type="text" id="name">
        </div>

        <div class="flex-item2">
          職種: <select category id="category">
            <option value="専門医">超音波専門医</option>
            <option value="検査士">超音波検査士</option>
            <option value="医師">医師</option>
            <option value="検査技師">臨床検査技師</option>
            <option value="放射線">放射線技師</option>
            <option value="その他">その他</option>
          </select>
        </div>

        <div class="flex-item3">
          地域: <select regidential id="regidential">
            <option value="北海道">北海道</option>
            <option value="東北">東北</option>
            <option value="関東">関東</option>
            <option value="中部">中部</option>
            <option value="近畿">近畿</option>
            <option value="中国・四国">中国・四国</option>
            <option value="九州">九州</option>
          </select>
        </div>
      </div>


      <!-- <div>
        回答画像: <select number id="number">
          <option value="画像１">画像１</option>
          <option value="画像２">画像２</option>
          <option value="画像３">画像３</option>
          <option value="画像４">画像４</option>
        </select>
      </div> -->

      <div class="flex-container2">
        <div>
          リクエスト: <select riquest id="riquest">
            <option value="他の画像をください">他の画像をください</option>
            <option value="拡大画像をください">拡大画像をください</option>
            <option value="カラードプラください">カラードプラください</option>
            <option value="画質をあげてください">画質をあげてください</option>
          </select>
        </div>

        <div>
          補助診断コメント: <select diag id="diag">
            <option value="救急搬送希望">救急搬送希望</option>
            <option value="後日専門医で精査希望">後日専門医で精査希望</option>
            <option value="悪性疑い">悪性疑い</option>
            <option value="良性疑い">良性疑い</option>
          </select>
        </div>
      </div>


      <div class="comment">
        コメント: <input type="text" id="text">
      </div>



      <div class="flex-container3">
        <div>
          <button type="button" id="send">送信</button>
        </div>

        <div>
          <button type="delete" id="delete">削除</button>
        </div>

      </div>


      <!-- グラフを横ならび -->
      <!-- グラフコンテナ -->
      <div id="chartContainer" style="display: flex;">

        <!-- 円グラフ1の要素 -->
        <div id="chart1Container">
          <canvas id="chart1"></canvas>
        </div>

        <!-- 円グラフ2の要素 -->
        <div id="chart2Container">
          <canvas id="chart2"></canvas>
        </div>

      </div>



      <!-- *******************************グラフにする******************************* -->

      <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.2.0/chart.min.js"
        integrity="sha512-VMsZqo0ar06BMtg0tPsdgRADvl0kDHpTbugCBBrL55KmucH6hP9zWdLIWY//OTfMnzz6xWQRxQqsUFefwHuHyg=="
        crossorigin="anonymous"></script>
      <script
        src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns@next/dist/chartjs-adapter-date-fns.bundle.min.js"></script>

      <!-- データ出力場所 -->
      <ul id="output"></ul>

      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
      <script>
        // 日時をいい感じの形式にする関数
        function convertTimestampToDatetime(timestamp) {
          const _d = timestamp ? new Date(timestamp * 1000) : new Date();
          const Y = _d.getFullYear();
          const m = (_d.getMonth() + 1).toString().padStart(2, '0');
          const d = _d.getDate().toString().padStart(2, '0');
          const H = _d.getHours().toString().padStart(2, '0');
          const i = _d.getMinutes().toString().padStart(2, '0');
          const s = _d.getSeconds().toString().padStart(2, '0');
          return `${Y}/${m}/${d} ${H}:${i}:${s}`;
        }
      </script>

      <!-- 以下にfirebaseのコードを貼り付けよう -->
      <script type="module">
        // Import the functions you need from the SDKs you need
        import { initializeApp } from "https://www.gstatic.com/firebasejs/9.22.1/firebase-app.js";
        // TODO: Add SDKs for Firebase products that you want to use
        // https://firebase.google.com/docs/web/setup#available-libraries
        import {
          getFirestore,
          collection,
          addDoc,
          serverTimestamp,
          onSnapshot,
          query,
          orderBy,
        } from "https://www.gstatic.com/firebasejs/9.22.1/firebase-firestore.js";

        // Your web app's Firebase configuration
        const firebaseConfig = {
          apiKey: "AIzaSyB_ia1EhF6uSj2K_g5pGO_7FMDke32Hh-Q",
          authDomain: "us-comment-app.firebaseapp.com",
          projectId: "us-comment-app",
          storageBucket: "us-comment-app.appspot.com",
          messagingSenderId: "337261613443",
          appId: "1:337261613443:web:cc7a645f6d1984fb12e6b6"
        };

        // Initialize Firebase
        const app = initializeApp(firebaseConfig);
        const db = getFirestore(app);

        // *************************************************************************************
        // 送信時に必要な処理

        $("#send").on("click", function () {

          const postData = {
            name: $("#name").val(),
            category: $("#category").val(),
            regidential: $("#regidential").val(),
            riquest: $("#riquest").val(),
            diag: $("#diag").val(),
            text: $("#text").val(),
            time: serverTimestamp(),
          };


          addDoc(collection(db, "chat"), postData);
          $("#name").val(),
            $("#category").val(),
            $("#regidential").val(),
            $("#riquest").val(),
            $("#diag").val(),
            $("#text").val("");

        });


        // 時間順に並び変え

        const q = query(collection(db, "chat"), orderBy("time", "desc"));

        onSnapshot(q, (querySnapshot) => {
          const documents = [];
          let myChart;
          let myChart2;

          querySnapshot.docs.forEach(function (doc) {
            const document = {
              id: doc.id,
              data: doc.data(),
            };
            documents.push(document);
          });

          console.log(documents);

          // ************グラフ作成******************************************

          // diag要素だけを抜き出す
          const diagElements = documents.map(function (document) {
            return document.data.diag;
          });

          console.log(diagElements);

          // *** 円グラフ1を描画する処理
          const count = {};
          for (const item of diagElements) {
            count[item] = (count[item] || 0) + 1;
          }

          // 概要（history配列内の出現回数をカウントしてlabelsへ）
          // labelsにcountを配列として返す
          const labels = Object.keys(count);
          // labels配列の各要素にcountの対応する値を取得しdataに配列として代入
          const data = labels.map(label => count[label]);


          if (myChart) {
            // チャートが既に存在する場合は破棄して再描画
            myChart.destroy();
          }

          const ctx = document.getElementById('chart1').getContext('2d');
          myChart = new Chart(ctx, {
            type: 'pie',
            data: {
              labels: labels,
              datasets: [{
                data: data,
                backgroundColor: ['red', 'orange', 'yellow', 'green', 'blue'],
              }]
            }
          });


          // // 円グラフ2を描画する処理//////////////////////////
          // category要素だけを抜き出す
          const categoryElements = documents.map(function (document) {
            return document.data.category;
          });

          console.log(categoryElements);

          // 円グラフ2を描画する処理/////
          const count2 = {};
          for (const item of categoryElements) {
            count2[item] = (count2[item] || 0) + 1;
          }

          // 概要（history配列内の出現回数をカウントしてlabelsへ）
          // labelsにcountを配列として返す
          const labels2 = Object.keys(count2);
          // labels配列の各要素にcountの対応する値を取得しdataに配列として代入
          const data2 = labels2.map(label2 => count2[label2]);


          if (myChart2) {
            // チャートが既に存在する場合は破棄して再描画
            myChart2.destroy();
          }

          const ctx2 = document.getElementById('chart2').getContext('2d');
          myChart2 = new Chart(ctx2, {
            type: 'bar',
            data: {
              labels: labels2,
              datasets: [{
                data: data2,
                backgroundColor: ['red', 'orange', 'yellow', 'green', 'blue'],
              }]
            }
          });




          // 画像表示用タグ生成
          const htmlElements = [];
          documents.forEach(function (document) {
            if (document.data.time) { // nullチェック
              htmlElements.push(`
        <li id="${document.id}">
          <p>${document.data.name} ${document.data.category}</p>
          <p>${document.data.riquest}</p>
          <p>${document.data.diag}</p>
          <p>${document.data.regidential}</p>
          <p>${document.data.text}</p>
          <p>at ${convertTimestampToDatetime(document.data.time.seconds)}</p>
        </li>
      `);
            }

          });


          // 削除機能
          $("#delete").on("click", function () {
            $("#name").val("");
            $("#category").val("");
            $("#regidential").val("");
            $("#riquest").val("");
            $("#diag").val("");
            $("#text").val("");
          });

          $("#output").html(htmlElements);
        });



      </script>

</body>

</html>