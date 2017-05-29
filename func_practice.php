<!DOCTYPE html>
<html>
<head>
	<title>aaa</title>
</head>
<body>

<?php

//NGな関数
// 数字が最初



hello();

// 引数がないとき
function hello(){
	echo "hello";
}
// 引数があるとき
function huga($hogehoge){
	echo $hogehoge;
}

// function aisatsu($name){
// 	echo 'はじめまして、ぼく'.$name.'!<br>';
// 	echo '元気？<br>';
// }
function nexseed($greeting,$name){
 return $greeting.$name;
	

	// echo $greeting . '、' . $name . 'さん';
}
echo nexseed('こんにちわ','シードくん');
echo '<br />';



//2つの値の合計値を計算する関数
function plus($num1,$num2){
	return $num1 + $num2;
	// echo '合計は'.$result.'円です。';
}

function multiplication($num3,$num4){
	return $num3 * $num4;
}

echo multiplication(10,10);
echo '<br />';

function avarage($num5,$num6){
	$ave = ($num5 + $num6) / 2;
	if ($ave < 10) {
		return 0;
	 }else{
	 	return $ave;
}
	}

echo avarage(1,2);
echo '<br />';

function shopping($money,$price){
   return $money - $price;

}

echo shopping(1000,200);
echo '<br>';

function bigger($num7,$num8){
   if ($num7 >= $num8){
   	return $num7;
   } else {
    return $num8;
   }
   	# code...
   }
   echo bigger(10,9);
   echo '<br>';

// 関数の呼び出す
$kekka = plus(10,5);
 echo '点数は'.$kekka.'点です';





?>


</body>
</html>