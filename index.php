<?php

//sessionをスタート
session_start();

//ログイン状態のチェック
//ログインしていると判断できる条件
//１．セッションにIDが入っていること
//２.最後の行動から一時間以内であること
if ((isset($_SESSION['login_member_id'])) && ($_SESSION['time'] + 3600 > time())){

  //ログインしている
  //セッションの時間更新
  $_SESSION['time'] = time();

}else{
  //ログインしていない
  header('Location: login.php');
  exit();
  # code...
}


//dbconnect.phpを読み込む
require('dbconnect.php');

//ログインしている人の情報を取得（名前を表示）
//SQL実行し、ユーザーのデータを取得
$sql = sprintf('SELECT * FROM `members` WHERE `member_id` = %d',mysqli_real_escape_string($db,$_SESSION['login_member_id']));

$record = mysqli_query($db,$sql) or die(mysqli_error($db));
$member = mysqli_fetch_assoc($record);
//DBへの接続
$dsn = 'mysql:dbname=seed_sns;host=localhost';
$user = 'root';
$password='';
$dbh = new PDO($dsn,$user,$password);
$dbh->query('SET NAMES utf8');


//sql文を実行する
if (!empty($_POST)){//POST送信したときのみ動くようにする
  $tweet = htmlspecialchars($_POST['tweet'],ENT_QUOTES,'UTF-8');
  $login_member_id = $_SESSION['login_member_id'];
  $reply_tweet_id = 0;
  $sql = sprintf('INSERT INTO `tweets`(`tweet`,`member_id`,`reply_tweet_id`,`created`,`modified`) VALUES ("%s","%s","%s",now(),now());',

    mysqli_real_escape_string($db,$tweet),
    mysqli_real_escape_string($db,$login_member_id),
    mysqli_real_escape_string($db,$reply_tweet_id)
    );
    mysqli_query($db,$sql) or die(mysqli_error($db));
  header("location: index.php");
  exit();
  # code...
    $stmt = $dbh->prepare($sql);
  $stmt->execute();
}
  //SELECT文の実行

  //SQL文作成(SELECT文)
  $sql = 'SELECT * FROM `tweets` ORDER BY `created` DESC;';

  //実行
$stmt = $dbh->prepare($sql);
  $stmt->execute();
    
   //配列で取得したデータを格納
   //配列を初期化
   $tweet_datas = array();
  //繰り返し文でデータ取得(フェッチ)
  while (1) {
    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($rec == false) {
      break;
      # code...
    }
    $tweet_datas[] = $rec;

  }
    # code...
  
  

   

$dbh = null;





?>





<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SeedSNS</title>

    <!-- Bootstrap -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="assets/css/form.css" rel="stylesheet">
    <link href="assets/css/timeline.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">

  </head>
  <body>
  <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header page-scroll">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="index.html"><span class="strong-title"><i class="fa fa-twitter-square"></i> Seed SNS</span></a>
          </div>
          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav navbar-right">
                <li><a href="logout.php">ログアウト</a></li>
              </ul>
          </div>
          <!-- /.navbar-collapse -->
      </div>
      <!-- /.container-fluid -->
  </nav>

  <div class="container">
    <div class="row">
      <div class="col-md-4 content-margin-top">
        <legend>ようこそ<?php echo $member['nick_name']; ?>さん！</legend>
        <form method="post" action="" class="form-horizontal" role="form">
            <!-- つぶやき -->
            <div class="form-group">
              <label class="col-sm-4 control-label">つぶやき</label>
              <div class="col-sm-8">
                <textarea name="tweet" cols="50" rows="5" class="form-control" placeholder="例：Hello World!"></textarea>
              </div>
            </div>
          <ul class="paging">
            <input type="submit" class="btn btn-info" value="つぶやく">
                &nbsp;&nbsp;&nbsp;&nbsp;
                <li><a href="index.html" class="btn btn-default">前</a></li>
                &nbsp;&nbsp;|&nbsp;&nbsp;
                <li><a href="index.html" class="btn btn-default">次</a></li>
          </ul>
        </form>
      </div>
      <?php foreach ($tweet_datas as $tweet_each){ ?>
      <div class="col-md-8 content-margin-top">
        <div class="msg">
          <img src="http://c85c7a.medialib.glogster.com/taniaarca/media/71/71c8671f98761a43f6f50a282e20f0b82bdb1f8c/blog-images-1349202732-fondo-steve-jobs-ipad.jpg" width="48" height="48">
          <p>
            <?php echo $tweet_each['tweet']; ?><span class="name"> (Seed kun) </span>
            [<a href="#">Re</a>]
          </p>
          <p class="day">
            <a href="view.html">
              2016-01-28 18:04
            </a>
            [<a href="#" style="color: #00994C;">編集</a>]
            [<a href="#" style="color: #F33;">削除</a>]
          </p>
        </div>
      </div>
      <?php } ?>
      </div>
      </div>
    

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="assets/js/jquery-3.1.1.js"></script>
    <script src="assets/js/jquery-migrate-1.4.1.js"></script>
    <script src="assets/js/bootstrap.js"></script>
  </body>
</html>
