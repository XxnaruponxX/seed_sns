<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<?php
$jsondata = file_get_contents('sample.json');
// var_dump($jsondata);

$array = json_decode($jsondata,true);
// var_dump($array);
echo '<br>';
echo 'お名前:'.$array['name'];

echo '<br>';
echo '性別:'.$array['gender'];

echo '<br>';
// 趣味をリスト形式で表示
// <ul>
?>
<ul>
<h3>趣味<h3/>
<li><?php echo $array['hobby'][0]; ?></li>
<li><?php echo $array['hobby'][1]; ?></li>
</ul>


</body>
</html>
