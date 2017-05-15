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
// $dsn = 'mysql:dbname=seed_sns;host=localhost';
// $user = 'root';
// $password='';
// $dbh = new PDO($dsn,$user,$password);
// $dbh->query('SET NAMES utf8');


//sql文を実行する
if (!empty($_POST)){//POST送信したときのみ動くようにする
  //$tweet = htmlspecialchars($_POST['tweet'],ENT_QUOTES,'UTF-8');
  $tweet = h($_POST['tweet']);
  $login_member_id = $_SESSION['login_member_id'];

  if (isset($_POST['reply_tweet_id'])) {
     $reply_tweet_id = $_POST['reply_tweet_id'];
   }else{
      $reply_tweet_id = 0;
    # code...
  }
 
  $sql = sprintf('INSERT INTO `tweets`(`tweet`,`member_id`,`reply_tweet_id`,`created`,`modified`) VALUES ("%s","%s","%s",now(),now());',

    mysqli_real_escape_string($db,$tweet),
    mysqli_real_escape_string($db,$login_member_id),
    mysqli_real_escape_string($db,$reply_tweet_id)
    );
    mysqli_query($db,$sql) or die(mysqli_error($db));
  header("location: index.php");
  exit();
  # code...
  //   $stmt = $dbh->prepare($sql);
  // $stmt->execute();
}
  //SELECT文の実行

  //SQL文作成(SELECT文)

       //投稿を取得する
       // $sql = 'SELECT * FROM `tweets`;';
       $sql = 'SELECT `members`.`nick_name`,`members`.`picture_path`,`tweets`.* FROM `tweets` INNER JOIN `members` on `tweets`.`member_id` = `members`.`member_id` WHERE `delete_flag`=0';
      $tweets = mysqli_query($db,$sql) or die(mysqli_error($db));
 

       $tweets_array = array();
       while ($tweet = mysqli_fetch_assoc($tweets)) {
       $tweets_array[] = $tweet;
       }

       //返信の場合
       if (isset($_REQUEST['res'])) {
        // 返信元のデータ（つぶやきとニックネーム）取得する
        $sql = 'SELECT `tweets`.`tweet`,`members`.`nick_name` FROM `tweets` INNER JOIN `members` on `tweets`.`member_id` = `members`.`member_id` WHERE `tweet_id`='.$_REQUEST['res'];
 
        $reply = mysqli_query($db,$sql) or die(mysqli_error($db));
        $reply_table = mysqli_fetch_assoc($reply);

        //「@ニックネーム　つぶやき」　という文字列をセット
        $reply_post = '@'.$reply_table['nick_name'].' '.$reply_table['tweet'].' ← ';
         # code...
       }

  //実行
// $stmt = $dbh->prepare($sql);
//   $stmt->execute();
    
//    //配列で取得したデータを格納
//    //配列を初期化
//    $tweet_datas = array();
//   //繰り返し文でデータ取得(フェッチ)
//   while (1) {
//     $rec = $stmt->fetch(PDO::FETCH_ASSOC);
//     if ($rec == false) {
//       break;
//       # code...
//     }
//     $tweet_datas[] = $rec;

  
    # code...
  
  

   

// $dbh = null;

// $input_value:変数
// h:関数名
// return oo :戻り値
function h($input_value){
  return htmlspecialchars($input_value,ENT_QUOTES,'UTF-8');

}


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
          <div class="collapse navbar-scollapse" id="bs-example-navbar-collapse-1">
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
              <?php if (isset($reply_post)){ ?>
              <textarea name="tweet" cols="50" rows="5" class="form-control" placeholder="例：Hello World!"><?php echo $reply_post; ?></textarea>
              <input type="hidden" name="reply_tweet_id" value="<?php echo $_REQUEST['res'];?>">
              <?php }else{ ?>
               <textarea name="tweet" cols="50" rows="5" class="form-control" placeholder="例：Hello World!"></textarea>
                <?php } ?>
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
      
      <div class="col-md-8 content-margin-top">
      <?php foreach ($tweets_array as $tweet_each){ ?>
        <div class="msg">
          <img src= "member_picture/<?php echo $tweet_each['picture_path'];?>" width="48" height="48">
          <p>
            <?php echo $tweet_each['tweet']; ?><span class="name"> (<?php echo $tweet_each['nick_name'];?>) </span>
            [<a href="index.php?res=<?php echo $tweet_each['tweet_id']; ?>">Re</a>]
          </p>
          <p class="day">
            <a href="view.php?tweet_id=<?php echo $tweet_each['tweet_id']; ?>">
             <?php echo $tweet_each['created']; ?>
            </a>
            <?php if ($tweet_each['reply_tweet_id'] > 0){ ?>
             
                        
            | <a href="view.php?tweet_id=<?php echo $tweet?>">返信元のつぶやき</a>
            <?php } ?>
            <?php
            if ($_SESSION['login_member_id'] == $tweet_each['member_id']) {
               # code...
             } 
            ?>
            [<a href="#" style="color: #00994C;">編集</a>]
            [<a href="delete.php?tweet_id=<?php echo $tweet_each['tweet_id']; ?>" style="color: #F33;">削除</a>]
          </p>

        </div>
        <?php } ?>
      </div>
      
      </div>
      </div>
    

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="assets/js/jquery-3.1.1.js"></script>
    <script src="assets/js/jquery-migrate-1.4.1.js"></script>
    <script src="assets/js/bootstrap.js"></script>
  </body>
</html>
