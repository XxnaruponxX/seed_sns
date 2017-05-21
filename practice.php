
<!DOCTYPE html>
<html lang="ja">
<head>
	<title>php復習</title>
</head>
<body>
<?php  


$omikuzi = array('小吉','大吉','凶','末吉','中吉');
$key = array_rand($omikuzi);
echo $omikuzi[$key];
echo '<br>';
?>
<?php
$Prefecture = array('name' =>'徳島', );
$japan = array($Prefecture);
$tikyuu = array($japan);
$ginga = array($tikyuu);
$universal = array($ginga);
echo $universal[0][0][0][0]['name'];



?>

</body>
</html>
