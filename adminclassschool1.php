<?php
session_start();
set_time_limit(240);
//require 'test.ru/connection.php' ;
require_once('../../connection.php');
//require_once( '../functions.php' );
require_once '../../Classes/PHPExcel.php';
$link = mysqli_connect($host, $user, $password, $database)
    or die("Ошибка " . mysqli_error($link));
$idschool =$_SESSION['choosenschool'];

$currentyear=$_SESSION['currentyear'];

function printex($type,$idschool,$class,$list,$obj){
	global $currentyear;
	$link = mysqli_connect("localhost", "root", "root123bai", "test")
    or die("Ошибка " . mysqli_error($link));
	$rayon=$_SESSION['choosenrayon'];
	$a=$type;
	$b=$idschool;
	$c=$class;
	$d=$list;
	$objPHPExcel=$obj;
	//$inputFileName = './testA.xlsx';
$checkendd=1;
/** Load $inputFileName to a PHPExcel Object **/


$queryid = "SELECT u.id  FROM user u WHERE u.test_type='$a' AND checkend=$checkendd AND u.yearcreate='$currentyear' $b$c";
  $resultid = mysqli_query($link, $queryid) or die("Ошибка " . mysqli_error($link));
  $rowex = 6 ;
while ($row2 = mysqli_fetch_assoc($resultid))
{
	$iduser=$row2['id'];
$query = "SELECT s.name_school, u.login, u.age, u.sex, u.spent_time,u.class,u.end_time FROM user u, school s WHERE u.id='$iduser' AND u.yearcreate='$currentyear' AND u.id_school=s.id_school";
  $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
  $count = mysqli_num_rows($result);
  if ($count == 1) {
	  $row = mysqli_fetch_assoc($result);
	$school=$row['name_school'];	  	
	$login = $row['login'];
	$age = $row['age'];
	$sex = $row['sex'];
	$time = $row['spent_time'];
	$class = $row['class'];

  }
  
  

$objPHPExcel->setActiveSheetIndex($d);
// Получаем активный лист
$sheet = $objPHPExcel->getActiveSheet();
//$sheet->setTitle("Тип $a(р-н $rayon )"); 

$sheet->setCellValueByColumnAndRow(1, $rowex, $school);
$sheet->setCellValueByColumnAndRow(2, $rowex, $class);
$sheet->setCellValueByColumnAndRow(3, $rowex, $login);
$sheet->setCellValueByColumnAndRow(5, $rowex, $age);
$sheet->setCellValueByColumnAndRow(4, $rowex, $sex);
if ($a=='A'){$sheet->setCellValueByColumnAndRow(178, $rowex, $time);}
if ($a=='B'){$sheet->setCellValueByColumnAndRow(211, $rowex, $time);}
if ($a=='C'){$sheet->setCellValueByColumnAndRow(211, $rowex, $time);}


$query1 = "SELECT  q.answer,vop.number FROM user u, answeruser q, question vop WHERE u.id='$iduser' AND u.id=q.id_user AND q.id_question=vop.id_question ORDER BY vop.number";
  $result1 = mysqli_query($link, $query1) or die("Ошибка " . mysqli_error($link));
  $count1 = mysqli_num_rows($result1);
  $col = 6 ;
  
while ($row1 = mysqli_fetch_assoc($result1))
{
	
    $answer = $row1['answer'];

	$sheet->setCellValueByColumnAndRow($col, $rowex, $answer);
	$col++;
	
}
 $rowex++ ;
}

	return $objPHPExcel;
	//$_SESSION['print']=1;
}	
		

function output($obj){
	$objPHP1=$obj;
	header("Content-Type:application/vnd.ms-excel");
header("Content-Disposition:attachment;filename=Результаты тестирования.xlsm");

$objWriter = PHPExcel_IOFactory::createWriter($objPHP1, 'Excel2007');

$objWriter->save('php://output');
 
exit(); 
}
function output2($obj){
	$objPHP1=$obj;
	header("Content-Type:application/vnd.ms-excel");
header("Content-Disposition:attachment;filename=Результаты тестирования.xlsx");

$objWriter = PHPExcel_IOFactory::createWriter($objPHP1, 'Excel2007');

$objWriter->save('php://output');
 
exit(); 
}
if(  $_POST['choosenclass']  ){ 
	 $val = $_POST['choosenclass'] ;
	 $_SESSION['choosenclass']=$val;

header("Location: adminclass.php"); 
	}
if(  $_POST['choosenclassanaliz']  ){ 
	 $val = $_POST['choosenclassanaliz'] ;
	 $_SESSION['choosenclass']=$val;

header("Location: diagram.php"); 
	}
	
	if(  $_POST['print']  ){ 
	
	$schoolselected = $_SESSION['choosenschool'];
		//$box = $_POST['box'];
	 $bdclass="AND u.id_school=$schoolselected";
	 //выбор чекбоксов, создание sql запроса
	$box = $_POST['box'];
		 $N = count($box);
   $bdclass .=" AND (";
   $kek=1;
    for($i=0; $i < $N; $i++)
    {
      $array[]=$box[$i];
	  
	   $bdclass .= "u.class='$array[$i]'";
	   if ($kek != $N){
	   $bdclass .= " OR ";
	   $kek++;
	   }
	 
    }
	$bdclass .=")";
		//echo $bdclass;
		//echo $schoolselected;
         // printex(A,$bdclass,""); 
		$test_typeA="A";
	$test_typeB="B";
	$test_typeC="C";
	$checkendd=1;
		  $CheckTypeBD="SELECT count(*) AS typeA, 
(SELECT count(*) FROM user u WHERE u.test_type = 'B' AND u.checkend=1 $bdclass) AS typeB, 
(SELECT count(*) FROM user u WHERE u.test_type ='C' AND u.checkend=1 $bdclass) AS typeC
FROM user u WHERE u.test_type = 'A' AND u.checkend=1 $bdclass;";
//echo $CheckTypeBD;
		    $resulCheckTypeBD = mysqli_query($link, $CheckTypeBD) or die("Ошибка " . mysqli_error($link));
			$count11 = mysqli_num_rows($resulCheckTypeBD);
  if ($count11 == 1) {
	   $row11 = mysqli_fetch_assoc($resulCheckTypeBD);
	$typeA=$row11['typeA'];	  	
	$typeB = $row11['typeB'];
	 $typeC = $row11['typeC'];
	 
	 $inputFileName = './testA.xlsm';
/** Load $inputFileName to a PHPExcel Object **/
$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);

	  if ($typeA!=0 && $typeB!=0 && $typeC!=0){
		 $objPHP= printex(A,$bdclass,"",0,$objPHPExcel);
		  $objPHP1= printex(B,$bdclass,"",1,$objPHP);
		   $objPHP2= printex(C,$bdclass,"",2,$objPHP1);
		   output($objPHP2);
	  }
	if ($typeA!=0 && $typeB==0 && $typeC!=0){
	   $objPHP= printex(A,$bdclass,"",0,$objPHPExcel);
		 $objPHP1= printex(C,$bdclass,"",1,$objPHP);  	 
		 output($objPHP1);  
	  }
	  if ($typeA==0 && $typeB!=0 && $typeC==0){
	   $objPHP= printex(B,$bdclass,"",1,$objPHPExcel);
		 
		 output($objPHP);  
	  }
	    if ($typeA!=0 && $typeB!=0 && $typeC==0){
	   $objPHP= printex(A,$bdclass,"",0,$objPHPExcel);
		 $objPHP1= printex(B,$bdclass,"",1,$objPHP);  	 
		 output($objPHP1);  
	  }
	   if ($typeA!=0 && $typeB==0 && $typeC==0){
	    $objPHP= printex(A,$bdclass,"",0,$objPHPExcel);
		 output($objPHP);  
	   }
	   if ($typeA==0 && $typeB!=0 && $typeC!=0){
		  $objPHP1= printex(B,$bdclass,"",1,$objPHPExcel);
		   $objPHP2= printex(C,$bdclass,"",2,$objPHP1);
		   output($objPHP2);

	   }
	   if ($typeA==0 && $typeB==0 && $typeC!=0){
		   $objPHP2= printex(C,$bdclass,"",2,$objPHPExcel);
		   output($objPHP2);
	   }
	   
	   if ($typeA==0 && $typeB==0 && $typeC==0){
		   echo "нет таких, ошибка строка 276";
	   }	
	}
	}
	//+
	if(  $_POST['deleteclass']  ){ 
	global $currentyear;
//echo "удаляем класс ";
$currentyear=$_SESSION['currentyear'];

	 $deleteclass=$_POST['deleteclass'];
	 $school=$_SESSION['choosenschool'];
	 $link = mysqli_connect("localhost", "root", "root123bai", "test")
    or die("Ошибка " . mysqli_error($link));
	
	$query11 = "SELECT u.id FROM user  u  WHERE u.class='$deleteclass' AND u.id_school= $school AND u.yearcreate='$currentyear'";
  $result11 = mysqli_query($link, $query11) or die("Ошибка " . mysqli_error($link));
  
   $answer="";
   $iduser="";
  
   while ($row1 = mysqli_fetch_assoc($result11))
{
	$iduser.="user.id=";
	$answer.="answeruser.id_user=";
	$answer.=$row1['id'];
	$iduser.=$row1['id'];
	   $answer .= " OR ";
	   $iduser .= " OR ";
	  
}

$bd1=mb_substr($answer,0,-4,'utf-8'); 
$iduser1=mb_substr($iduser,0,-4,'utf-8');	


 //$link = mysqli_connect("localhost", "root", "root123bai", "test");
 $query1 = "DELETE FROM  `answeruser` WHERE $bd1";
 //echo $query1;
 $query2 ="DELETE FROM `user` WHERE $iduser1";
 //echo $query2;
 $query3 ="DELETE FROM `class` WHERE class.name_class ='$deleteclass' AND class.id_school=$school AND class.yearcreate='$currentyear'" ;
 //echo $query3;
   $result1 = mysqli_query($link, $query1) or die("Ошибка " . mysqli_error($link));
  $result2 = mysqli_query($link, $query2) or die("Ошибка " . mysqli_error($link));
  $result3 = mysqli_query($link, $query3) or die("Ошибка " . mysqli_error($link));
 // $_SESSION['DEL']="Пользователь удален";
  exit('<meta http-equiv="refresh" content="0; url=adminclassschool.php" />');

}

//+
if(  $_POST['choosenclassobrabotano']  ){ 
global $currentyear;
	 $deleteclass=$_POST['choosenclassobrabotano'];
	 $school=$_SESSION['choosenschool'];
	$query3 ="UPDATE `class` set checkobrabotka=1 WHERE class.name_class ='$deleteclass' AND class.id_school=$school AND class.yearcreate='$currentyear'";

   $result1 = mysqli_query($link, $query3) or die("Ошибка " . mysqli_error($link));
    exit('<meta http-equiv="refresh" content="0; url=adminclassschool.php" />');
	}
	//+
	if(  $_POST['choosenclassvozobnovit']  ){ 
	 $deleteclass=$_POST['choosenclassvozobnovit'];
	 $school=$_SESSION['choosenschool'];
	$query3 ="UPDATE `class` set checkend=0,checkobrabotka=0, end_time=NULL WHERE class.name_class ='$deleteclass' AND class.id_school=$school AND class.yearcreate='$currentyear'";

   $result1 = mysqli_query($link, $query3) or die("Ошибка " . mysqli_error($link));
    exit('<meta http-equiv="refresh" content="0; url=adminclassschool.php" />');
	}
if(  $_POST['choosenclassedit']  ){
	$editclass=$_POST['choosenclassedit'];
	$school=$_SESSION['choosenschool'];
	$_SESSION['editclass']=$editclass;
	header ('Location: editclass.php');

}


if(  $_POST['choosenclasszakonchit']  ){ 
	global $currentyear;
	$class = $_POST['choosenclasszakonchit'] ;
	$idschool=$_SESSION['choosenschool'];
	 $time=
$link = mysqli_connect("localhost", "root", "root123bai", "test");
//установка чека
	$query1 = "Update class  SET checkend=1, end_time=now() where id_school='$idschool' AND name_class='$class' AND yearcreate='$currentyear'";
 
  $result1 = mysqli_query($link, $query1) or die("Ошибка " . mysqli_error($link));
  
  //удаление пустых логинов
  $query222 = "DELETE from user where checkend=0 AND id_school='$idschool' AND class='$class' AND yearcreate='$currentyear'";
 
  $result222 = mysqli_query($link, $query222) or die("Ошибка " . mysqli_error($link));
  
  //обработка класса
  
  $query = "SELECT id_school,name_class FROM class ";
  $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));


	
    $nameclass = $class;

	$query1 = "SELECT count(*) AS Col,
(SELECT count(*)FROM user_obrabotka WHERE user_obrabotka.id_user in (SELECT id from user WHERE class='$nameclass' AND id_school=$idschool AND yearcreate='$currentyear' AND user_obrabotka.nd='Недостоверно') 
) AS Colnedostover,
(SELECT count(*)FROM user_obrabotka WHERE user_obrabotka.id_user in (SELECT id from user WHERE class='$nameclass' AND id_school=$idschool AND yearcreate='$currentyear' AND user_obrabotka.nd='Достоверно') 
) AS Coldostover,
(SELECT count(*)FROM user_obrabotka WHERE user_obrabotka.id_user in (SELECT id from user WHERE class='$nameclass' AND id_school=$idschool AND yearcreate='$currentyear' AND user_obrabotka.PVV_1of2='ПВВ'  AND user_obrabotka.nd='Достоверно' ) 
) AS ColPVV,
(SELECT count(*)FROM user_obrabotka WHERE user_obrabotka.id_user in (SELECT id from user WHERE class='$nameclass' AND id_school=$idschool AND yearcreate='$currentyear' AND  user_obrabotka.PVV_Obe!='ПВВ обе'AND user_obrabotka.nd='Достоверно' AND  user_obrabotka.PVV_1of2='ПВВ') 
) AS ColPVV1of2,
(SELECT count(*)FROM user_obrabotka WHERE user_obrabotka.id_user in (SELECT id from user WHERE class='$nameclass' AND id_school=$idschool AND yearcreate='$currentyear' AND  user_obrabotka.PVV_Obe='ПВВ обе'AND user_obrabotka.nd='Достоверно') 
) AS ColPVV1obe
FROM user_obrabotka WHERE user_obrabotka.id_user in (SELECT id from user WHERE class='$nameclass' AND id_school=$idschool AND yearcreate='$currentyear') ";
  $result1 = mysqli_query($link, $query1) or die("Ошибка " . mysqli_error($link));
	while ($row1 = mysqli_fetch_assoc($result1))
	{
	$Col=$row1['Col'];
    $Colnedostover = $row1['Colnedostover'];
	$Coldostover=$row1['Coldostover'];
    $ColPVV = $row1['ColPVV'];
	$ColPVV1of2=$row1['ColPVV1of2'];
    $ColPVV1obe = $row1['ColPVV1obe'];
	
	}

	 $queryupdateclass = "UPDATE `class` set Col='$Col', Colnedostover='$Colnedostover', Coldostover='$Coldostover', ColPVV='$ColPVV', ColPVV1of2='$ColPVV1of2', ColPVV1obe='$ColPVV1obe'  WHERE name_class= '$nameclass' AND id_school=$idschool AND yearcreate='$currentyear'";
     $resultupdateclass = mysqli_query($link, $queryupdateclass) or die("Ошибка " . mysqli_error($link));
	

	//echo "цикл закончен, обновлено";
  exit('<meta http-equiv="refresh" content="0; url=adminclassschool.php" />');
  
  
  
}


//+
if(  $_POST['printempty']  ){ 
global $currentyear;
	$schoolselected = $_SESSION['choosenschool'];
		//$box = $_POST['box'];
	 $bdclass="AND u.id_school=$schoolselected AND u.yearcreate='$currentyear'";
	 //выбор чекбоксов, создание sql запроса
	$box = $_POST['box'];
		 $N = count($box);
   $bdclass .=" AND (";
   $kek=1;
    for($i=0; $i < $N; $i++)
    {
      $array[]=$box[$i];
	  
	   $bdclass .= "u.class='$array[$i]'";
	   if ($kek != $N){
	   $bdclass .= " OR ";
	   $kek++;
	   }
	 
    }
	$bdclass .=")";
		//echo $bdclass;
		//echo $schoolselected;
         // printex(A,$bdclass,""); 
		
		  $CheckTypeBD="SELECT count(*) AS typeA, 
(SELECT count(*) FROM user u WHERE u.test_type = 'B' AND u.checkend=1 $bdclass) AS typeB, 
(SELECT count(*) FROM user u WHERE u.test_type ='C' AND u.checkend=1 $bdclass) AS typeC
FROM user u WHERE u.test_type = 'A' AND u.checkend=1 $bdclass;";
		    $resulCheckTypeBD = mysqli_query($link, $CheckTypeBD) or die("Ошибка " . mysqli_error($link));
			$count11 = mysqli_num_rows($resulCheckTypeBD);
  if ($count11 == 1) {
	   $row11 = mysqli_fetch_assoc($resulCheckTypeBD);
	$typeA=$row11['typeA'];	  	
	$typeB = $row11['typeB'];
	 $typeC = $row11['typeC'];
	 
	 $inputFileName = './testAempty.xlsx';
/** Load $inputFileName to a PHPExcel Object **/

$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);

	  if ($typeA!=0 && $typeB!=0 && $typeC!=0){
		 $objPHP= printex(A,$bdclass,"",0,$objPHPExcel);
		  $objPHP1= printex(B,$bdclass,"",1,$objPHP);
		   $objPHP2= printex(C,$bdclass,"",2,$objPHP1);
		   output2($objPHP2);
	  }
	if ($typeA!=0 && $typeB==0 && $typeC!=0){
	   $objPHP= printex(A,$bdclass,"",0,$objPHPExcel);
		 $objPHP1= printex(C,$bdclass,"",1,$objPHP);  	 
		 output2($objPHP1);  
	  }
	  if ($typeA==0 && $typeB!=0 && $typeC==0){
	   $objPHP= printex(B,$bdclass,"",1,$objPHPExcel);
		 
		 output2($objPHP);  
	  }
	    if ($typeA!=0 && $typeB!=0 && $typeC==0){
	   $objPHP= printex(A,$bdclass,"",0,$objPHPExcel);
		 $objPHP1= printex(B,$bdclass,"",1,$objPHP);  	 
		 output2($objPHP1);  
	  }
	   if ($typeA!=0 && $typeB==0 && $typeC==0){
	    $objPHP= printex(A,$bdclass,"",0,$objPHPExcel);
		 output2($objPHP);  
	   }
	   if ($typeA==0 && $typeB!=0 && $typeC!=0){
		  $objPHP1= printex(B,$bdclass,"",1,$objPHPExcel);
		   $objPHP2= printex(C,$bdclass,"",2,$objPHP1);
		   output2($objPHP2);

	   }
	   if ($typeA==0 && $typeB==0 && $typeC!=0){
		   $objPHP2= printex(C,$bdclass,"",2,$objPHPExcel);
		   output2($objPHP2);
	   }
	   
	   if ($typeA==0 && $typeB==0 && $typeC==0){
		   echo "нет таких, ошибка строка 256";
	   }	
	}
	}
	
?>
