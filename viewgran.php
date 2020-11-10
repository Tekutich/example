<?php
session_start();
require_once('../../connection.php');
$currentyear=$_SESSION['currentyear'];
if ($_SESSION['type_user']=="admin"){
	//echo $_SESSION['ClassesGranBD'];
	//echo $_SESSION['test_typerazchet'];
} else {header("Location: ../main.html");}
$currentyear=$_SESSION['currentyear'];

 function upgran ($array){
	 
	  //стандарт отклонение
 $standard_deviation = stats_standard_deviation($array);
 
 //сигма
 $sigma=round($standard_deviation/2,2);
 //среднее
$avg = round(array_sum($array)/count($array),2);
//верхняя граница
$granverx=$sigma+$avg;
//нижняя граница
$granniz=$avg-$sigma;
 
return $granverx;
 }
 function downgran ($array){
	 
	  //стандарт отклонение
 $standard_deviation = stats_standard_deviation($array);
 
 //сигма
 $sigma=round($standard_deviation/2,2);
 //среднее
$avg = round(array_sum($array)/count($array),2);
//верхняя граница
$granverx=$sigma+$avg;
//нижняя граница
$granniz=$avg-$sigma;
 
return $granniz;
 }

function GetGran(){
	global $link;
	global $currentyear;
	$test_typerazchet=$_SESSION['test_typerazchet'];
	//извлечение текущих границ
	$querySet = "SELECT * FROM settings where currentyear='$currentyear' ";
  $resultSet = mysqli_query($link, $querySet) or die("Ошибка " . mysqli_error($link));
 
  
while ($rowSet = mysqli_fetch_assoc($resultSet))
{
	//тип А
	$PopercentTypeAcurrent=$rowSet['PopercentTypeA'];
	$PVGpercentTypeAcurrent=$rowSet['PVGpercentTypeA'];
	$PAUpercentTypeAcurrent=$rowSet['PAUpercentTypeA'];
	$CPpercentTypeAcurrent=$rowSet['CPpercentTypeA'];
	$IpercentTypeAcurrent=$rowSet['IpercentTypeA'];
	$TpercentTypeAcurrent=$rowSet['TpercentTypeA'];
	
	$PRpercentTypeAcurrent=$rowSet['PRpercentTypeA'];
	$PO_3percentTypeAcurrent=$rowSet['PO_3percentTypeA'];
	$CApercentTypeAcurrent=$rowSet['CApercentTypeA'];
	$CP_3percentTypeAcurrent=$rowSet['CP_3percentTypeA'];
	
	$FRMethod2percentTypeAcurrent=$rowSet['FRMethod2TypeA'];
	$FZMethod2percentTypeAcurrent=$rowSet['FZMethod2TypeA'];
	
	
	//тип Б
	$PopercentTypeBcurrent=$rowSet['PopercentTypeB'];
	$PVGpercentTypeBcurrent=$rowSet['PVGpercentTypeB'];
	$PAUpercentTypeBcurrent=$rowSet['PAUpercentTypeB'];
	$CPpercentTypeBcurrent=$rowSet['CPpercentTypeB'];
	$IpercentTypeBcurrent=$rowSet['IpercentTypeB'];
	$TpercentTypeBcurrent=$rowSet['TpercentTypeB'];
	$FpercentTypeBcurrent=$rowSet['FpercentTypeB'];
	$NSOpercentTypeBcurrent=$rowSet['NSOpercentTypeB'];
	
	$PRpercentTypeBcurrent=$rowSet['PRpercentTypeB'];
	$PO_3percentTypeBcurrent=$rowSet['PO_3percentTypeB'];
	$CApercentTypeBcurrent=$rowSet['CApercentTypeB'];
	$CP_3percentTypeBcurrent=$rowSet['CP_3percentTypeB'];
	$SpercentTypeBcurrent=$rowSet['SpercentTypeB'];
	
	$FRMethod2percentTypeBcurrent=$rowSet['FRMethod2TypeB'];
	$FZMethod2percentTypeBcurrent=$rowSet['FZMethod2TypeB'];
	
	
	
	//тип c
	$PopercentTypeCcurrent=$rowSet['PopercentTypeC'];
	$PVGpercentTypeCcurrent=$rowSet['PVGpercentTypeC'];
	$PAUpercentTypeCcurrent=$rowSet['PAUpercentTypeC'];
	$CPpercentTypeCcurrent=$rowSet['CPpercentTypeC'];
	$IpercentTypeCcurrent=$rowSet['IpercentTypeC'];
	$TpercentTypeCcurrent=$rowSet['TpercentTypeC'];
	$FpercentTypeCcurrent=$rowSet['FpercentTypeC'];
	$NSOpercentTypeCcurrent=$rowSet['NSOpercentTypeC'];
	
	$PRpercentTypeCcurrent=$rowSet['PRpercentTypeC'];
	$PO_3percentTypeCcurrent=$rowSet['PO_3percentTypeC'];
	$CApercentTypeCcurrent=$rowSet['CApercentTypeC'];
	$CP_3percentTypeCcurrent=$rowSet['CP_3percentTypeC'];
	$SpercentTypeCcurrent=$rowSet['SpercentTypeC'];
	
	
	$FRMethod2percentTypeCcurrent=$rowSet['FRMethod2TypeC'];
	$FZMethod2percentTypeCcurrent=$rowSet['FZMethod2TypeC'];
}


	
	if ($test_typerazchet=="A"){
		global $link;
	global $currentyear;
	$classes=$_SESSION['ClassesGranBD'];
	$classes.=")";
	//тут расчет новых границ типа А

			$queryGran = "SELECT * FROM `user_obrabotka` where id_user in (SELECT id from user where $classes ";
  $resultGran = mysqli_query($link, $queryGran) or die("Ошибка " . mysqli_error($link));
 
  
while ($rowGran = mysqli_fetch_assoc($resultGran))
{
	//фр
	$FrPo[]=$rowGran['popercent'];
	$FrPvg[]=$rowGran['pvgpercent'];
	$FrPay[]=$rowGran['paypercent'];
	$FrCp[]=$rowGran['cppercent'];
	$FrI[]=$rowGran['ipercent'];
	$FrT[]=$rowGran['tpercent'];
	$FrM2[]=$rowGran['FRMethod2percent'];
	
	//фз
	$FzPr[]=$rowGran['pr_3percent'];
	$FzPo[]=$rowGran['po_3percent'];
	$FzCa[]=$rowGran['ca_3percent'];
	$FzCp[]=$rowGran['cp_3percent'];
	$FzM2[]=$rowGran['FZMethod2percent'];
}
		
		
		//границы фр
		$GranFrPo=upgran($FrPo);
		$GranFrPvg=upgran($FrPvg);
		$GranFrPay=upgran($FrPay);
		$GranFrCp=upgran($FrCp);
		$GranFrI=upgran($FrI);
		$GranFrT=upgran($FrT);
		$GranFrM2=upgran($FrM2);
		//гранциы фз
		$GranFzPr=downgran($FzPr);
		$GranFzPo=downgran($FzPo);
		$GranFzCa=downgran($FzCa);
		$GranFzCp=downgran($FzCp);
		$GranFzM2=downgran($FzM2);
		
		
		
		//вывод в график
	$granchart="
	{
        Показатель: 'По (ФР)',
        Текущие_границы: $PopercentTypeAcurrent,
        Вычисленные_границы: $GranFrPo
    },
    {
        Показатель: 'ПВГ (ФР)',
        Текущие_границы: $PVGpercentTypeAcurrent,
        Вычисленные_границы: $GranFrPvg
    },
    {
        Показатель: 'ПАУ (ФР)',
        Текущие_границы: $PAUpercentTypeAcurrent,
        Вычисленные_границы: $GranFrPay
    },
    {
        Показатель: 'СР (ФР)',
        Текущие_границы: $CPpercentTypeAcurrent,
        Вычисленные_границы: $GranFrCp
    },
    {
        Показатель: 'И (ФР)',
        Текущие_границы: $IpercentTypeAcurrent,
        Вычисленные_границы: $GranFrI
    },
    {
        Показатель: 'Т (ФР)',
        Текущие_границы: $TpercentTypeAcurrent,
        Вычисленные_границы: $GranFrT
    },
	
	{
        Показатель: 'ФР М.2 (ФР)',
        Текущие_границы: $FRMethod2percentTypeAcurrent,
        Вычисленные_границы: $GranFrM2
    },
    {
        Показатель: 'ПР (ФЗ)',
        Текущие_границы: $PRpercentTypeAcurrent,
        Вычисленные_границы: $GranFzPr
    },
    {
        Показатель: 'ПО (ФЗ)',
        Текущие_границы: $PO_3percentTypeAcurrent,
        Вычисленные_границы: $GranFzPo
    },
    {
        Показатель: 'СА (ФЗ)',
        Текущие_границы: $CApercentTypeAcurrent,
        Вычисленные_границы: $GranFzCa
    },
    {
        Показатель: 'СП (ФЗ)',
        Текущие_границы: $CP_3percentTypeAcurrent,
        Вычисленные_границы: $GranFzCp
    },
	
	{
        Показатель: 'ФЗ М.2 (ФЗ)',
        Текущие_границы: $FZMethod2percentTypeAcurrent,
        Вычисленные_границы: $GranFzM2
    }
	";
	}
	
	
	if ($test_typerazchet=="B"){
		//тут расчет новых границ типа B
		global $link;
	global $currentyear;
	$classes=$_SESSION['ClassesGranBD'];
	$classes.=")";
	//тут расчет новых границ типа B

			$queryGran = "SELECT * FROM `user_obrabotka` where id_user in (SELECT id from user where $classes ";
  $resultGran = mysqli_query($link, $queryGran) or die("Ошибка " . mysqli_error($link));
		
		
		  
while ($rowGran = mysqli_fetch_assoc($resultGran))
{
	//фр
	$FrPo[]=$rowGran['popercent'];
	$FrPvg[]=$rowGran['pvgpercent'];
	$FrPay[]=$rowGran['paypercent'];
	$FrCp[]=$rowGran['cppercent'];
	$FrI[]=$rowGran['ipercent'];
	$FrT[]=$rowGran['tpercent'];
	//доп фр (для типов b,c)
	$FrF[]=$rowGran['fpercent'];
	$FrNSO[]=$rowGran['nsopercent'];
	
	$FrM2[]=$rowGran['FRMethod2percent'];
	
	//фз
	$FzPr[]=$rowGran['pr_3percent'];
	$FzPo[]=$rowGran['po_3percent'];
	$FzCa[]=$rowGran['ca_3percent'];
	$FzCp[]=$rowGran['cp_3percent'];
	//доп фз (для типов b,c)
	$FzS[]=$rowGran['spercent'];
	
	$FzM2[]=$rowGran['FZMethod2percent'];
}
		
		
		//границы фр
		$GranFrPo=upgran($FrPo);
		$GranFrPvg=upgran($FrPvg);
		$GranFrPay=upgran($FrPay);
		$GranFrCp=upgran($FrCp);
		$GranFrI=upgran($FrI);
		$GranFrT=upgran($FrT);
		$GranFrM2=upgran($FrM2);
			//доп фр (для типов b,c)
		$GranFrF=upgran($FrF);
		$GranFrNSO=upgran($FrNSO);
		
		//гранциы фз
		$GranFzPr=downgran($FzPr);
		$GranFzPo=downgran($FzPo);
		$GranFzCa=downgran($FzCa);
		$GranFzCp=downgran($FzCp);
		$GranFzM2=downgran($FzM2);
			//доп фз (для типов b,c)
			$GranFzS=downgran($FzS);

		
		
		
		
		
		
	$granchart="
	{
        Показатель: 'По (ФР)',
        Текущие_границы: $PopercentTypeBcurrent,
        Вычисленные_границы: $GranFrPo
    },
    {
        Показатель: 'ПВГ (ФР)',
        Текущие_границы: $PVGpercentTypeBcurrent,
        Вычисленные_границы: $GranFrPvg
    },
    {
        Показатель: 'ПАУ (ФР)',
        Текущие_границы: $PAUpercentTypeBcurrent,
        Вычисленные_границы: $GranFrPay
    },
    {
        Показатель: 'СР (ФР)',
        Текущие_границы: $CPpercentTypeBcurrent,
        Вычисленные_границы: $GranFrCp
    },
    {
        Показатель: 'И (ФР)',
        Текущие_границы: $IpercentTypeBcurrent,
        Вычисленные_границы: $GranFrI
    },
    {
        Показатель: 'Т (ФР)',
        Текущие_границы: $TpercentTypeBcurrent,
        Вычисленные_границы: $GranFrT
    },
    {
        Показатель: 'Ф (ФЗ)',
        Текущие_границы: $FpercentTypeBcurrent,
        Вычисленные_границы: $GranFrF
    },
	{
        Показатель: 'НСО (ФЗ)',
        Текущие_границы: $NSOpercentTypeBcurrent,
        Вычисленные_границы: $GranFrNSO
    },
	
	{
        Показатель: 'ФР М.2 (ФР)',
        Текущие_границы: $FRMethod2percentTypeBcurrent,
        Вычисленные_границы: $GranFrM2
    },
	
	
	
	
	
	
	
	
	
	
	{
        Показатель: 'ПР (ФЗ)',
        Текущие_границы: $PRpercentTypeBcurrent,
        Вычисленные_границы: $GranFzPr
    },
    {
        Показатель: 'ПО (ФЗ)',
        Текущие_границы: $PO_3percentTypeBcurrent,
        Вычисленные_границы: $GranFzPo
    },
    {
        Показатель: 'СА (ФЗ)',
        Текущие_границы: $CApercentTypeBcurrent,
        Вычисленные_границы: $GranFzCa
    },
    {
        Показатель: 'СП (ФЗ)',
        Текущие_границы: $CP_3percentTypeBcurrent,
        Вычисленные_границы: $GranFzCp
    },
    {
        Показатель: 'С (ФЗ)',
        Текущие_границы: $SpercentTypeBcurrent,
        Вычисленные_границы: $GranFzS
    },
	
	{
        Показатель: 'ФЗ М.2 (ФЗ)',
        Текущие_границы: $FZMethod2percentTypeBcurrent,
        Вычисленные_границы: $GranFzM2
    }
	
	
	";
	}
	
	



if ($test_typerazchet=="C"){
		//тут расчет новых границ типа С
		
		
		global $link;
	global $currentyear;
	$classes=$_SESSION['ClassesGranBD'];
	$classes.=")";
	//тут расчет новых границ типа С

			$queryGran = "SELECT * FROM `user_obrabotka` where id_user in (SELECT id from user where $classes ";
  $resultGran = mysqli_query($link, $queryGran) or die("Ошибка " . mysqli_error($link));
		
		
		  
while ($rowGran = mysqli_fetch_assoc($resultGran))
{
	//фр
	$FrPo[]=$rowGran['popercent'];
	$FrPvg[]=$rowGran['pvgpercent'];
	$FrPay[]=$rowGran['paypercent'];
	$FrCp[]=$rowGran['cppercent'];
	$FrI[]=$rowGran['ipercent'];
	$FrT[]=$rowGran['tpercent'];
	//доп фр (для типов b,c)
	$FrF[]=$rowGran['fpercent'];
	$FrNSO[]=$rowGran['nsopercent'];
	
	$FrM2[]=$rowGran['FRMethod2percent'];
	
	//фз
	$FzPr[]=$rowGran['pr_3percent'];
	$FzPo[]=$rowGran['po_3percent'];
	$FzCa[]=$rowGran['ca_3percent'];
	$FzCp[]=$rowGran['cp_3percent'];
	//доп фз (для типов b,c)
	$FzS[]=$rowGran['spercent'];
	
	$FzM2[]=$rowGran['FZMethod2percent'];
}
		
		
		//границы фр
		$GranFrPo=upgran($FrPo);
		$GranFrPvg=upgran($FrPvg);
		$GranFrPay=upgran($FrPay);
		$GranFrCp=upgran($FrCp);
		$GranFrI=upgran($FrI);
		$GranFrT=upgran($FrT);
		$GranFrM2=upgran($FrM2);
			//доп фр (для типов b,c)
		$GranFrF=upgran($FrF);
		$GranFrNSO=upgran($FrNSO);
		
		//гранциы фз
		$GranFzPr=downgran($FzPr);
		$GranFzPo=downgran($FzPo);
		$GranFzCa=downgran($FzCa);
		$GranFzCp=downgran($FzCp);
		$GranFzM2=downgran($FzM2);
			//доп фз (для типов b,c)
			$GranFzS=downgran($FzS);

		
		
		
		
		
		
		
	$granchart="
	{
        Показатель: 'По (ФР)',
        Текущие_границы: $PopercentTypeCcurrent,
        Вычисленные_границы: $GranFrPo
    },
    {
        Показатель: 'ПВГ (ФР)',
        Текущие_границы: $PVGpercentTypeCcurrent,
        Вычисленные_границы: $GranFrPvg
    },
    {
        Показатель: 'ПАУ (ФР)',
        Текущие_границы: $PAUpercentTypeCcurrent,
        Вычисленные_границы: $GranFrPay
    },
    {
        Показатель: 'СР (ФР)',
        Текущие_границы: $CPpercentTypeCcurrent,
        Вычисленные_границы: $GranFrCp
    },
    {
        Показатель: 'И (ФР)',
        Текущие_границы: $IpercentTypeCcurrent,
        Вычисленные_границы: $GranFrI
    },
    {
        Показатель: 'Т (ФР)',
        Текущие_границы: $TpercentTypeCcurrent,
        Вычисленные_границы: $GranFrT
    },
    {
        Показатель: 'Ф (ФР)',
        Текущие_границы: $FpercentTypeCcurrent,
        Вычисленные_границы: $GranFrF
    },
	{
        Показатель: 'НСО (ФР)',
        Текущие_границы: $NSOpercentTypeCcurrent,
        Вычисленные_границы: $GranFrNSO
    },
	
	{
        Показатель: 'ФЗ М.2 (ФЗ)',
        Текущие_границы: $FRMethod2percentTypeCcurrent,
        Вычисленные_границы: $GranFrM2
    },
	
	
	
	
	
	
	
	
	
	{
        Показатель: 'ПР (ФЗ)',
        Текущие_границы: $PRpercentTypeCcurrent,
        Вычисленные_границы: $GranFzPr
    },
    {
        Показатель: 'ПО (ФЗ)',
        Текущие_границы: $PO_3percentTypeCcurrent,
        Вычисленные_границы: $GranFzPo
    },
    {
        Показатель: 'СА (ФЗ)',
        Текущие_границы: $CApercentTypeCcurrent,
        Вычисленные_границы: $GranFzCa
    },
    {
        Показатель: 'СП (ФЗ)',
        Текущие_границы: $CP_3percentTypeCcurrent,
        Вычисленные_границы: $GranFzCp
    },
    {
        Показатель: 'С (ФЗ)',
        Текущие_границы: $SpercentTypeCcurrent,
        Вычисленные_границы: $GranFzS
    },
	
	{
        Показатель: 'ФЗ М.2 (ФЗ)',
        Текущие_границы: $FZMethod2percentTypeCcurrent,
        Вычисленные_границы: $GranFzM2
    }
	
	
	";
	}	
	
	
	return $granchart;
}
?>
<html >
<head>
<link rel="shortcut icon" href="../../icon.ico" type="image/x-icon">
<!-- Styles -->
<style>
#chartdiv {
  width: 100%;
  height: 550px;
}
#left{
	position: absolute;
top: 10;
left: 0;
bottom: 0;
right: 100;
margin: auto;
font-size:10px;
widght: 150px;
height: 60px;
}
.kek
{
       display: inline-block;
	 
}
</style>
<script src="../../js/jquery-3.4.1.js"></script>
<!-- Resources -->
<script src="../../amcharts4/core.js"></script>
<script src="../../amcharts4/charts.js"></script>
<script src="../../amcharts4/themes/animated.js"></script>
<script src="../../amcharts4/lang/ru_RU.js"></script>


<!-- Chart code -->
<script>
 $(window).on('load', function () {
	 
      $('.preloader').fadeOut().delay(400).fadeOut('slow');
    });



am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end



var chart = am4core.create('chartdiv', am4charts.XYChart)

chart.colors.list = [
  am4core.color("#008000"),
  am4core.color("#0000ff"),
];

chart.language.locale = am4lang_ru_RU;
let title = chart.titles.create();
title.text = "Диаграмма границ в %";
title.fontSize = 20;
title.marginBottom = 10;

chart.exporting.menu = new am4core.ExportMenu();
chart.exporting.filePrefix = 'Вычисленные границы';

chart.legend = new am4charts.Legend()
chart.legend.position = 'top'
chart.legend.paddingBottom = 20
chart.legend.labels.template.maxWidth = 95

var xAxis = chart.xAxes.push(new am4charts.CategoryAxis())
xAxis.dataFields.category = 'Показатель'
xAxis.renderer.minGridDistance = 10;
xAxis.renderer.cellStartLocation = 0.05
xAxis.renderer.cellEndLocation = 0.95
xAxis.renderer.grid.template.location = 0;

var yAxis = chart.yAxes.push(new am4charts.ValueAxis());
yAxis.min = 0;

function createSeries(value, name) {
    var series = chart.series.push(new am4charts.ColumnSeries())
    series.dataFields.valueY = value
    series.dataFields.categoryX = 'Показатель'
    series.name = name

    series.events.on("hidden", arrangeColumns);
    series.events.on("shown", arrangeColumns);

  /*   var bullet = series.bullets.push(new am4charts.LabelBullet())
    bullet.interactionsEnabled = false
	bullet.align = "center";
bullet.valign = "middle";
bullet.properties.scale = 0.5;

bullet.propertyFields.rotation = "angle";


    bullet.dy = 30;
    bullet.label.text = '{valueY}'
    bullet.label.fill = am4core.color('#ffffff') */
    series.columns.template.tooltipText = "{name}\n {Показатель}: [bold]{valueY}[/]";

var labelBullet = series.bullets.push(new am4charts.LabelBullet());
labelBullet.label.verticalCenter = "bottom";
labelBullet.label.dy = -10;
labelBullet.label.text = '{valueY}';

    return series;
}

chart.data = [
    <?=GetGran();?>
]


createSeries('Текущие_границы', 'Текущие границы');
createSeries('Вычисленные_границы', 'Вычисленные границы');


function arrangeColumns() {

    var series = chart.series.getIndex(0);

    var w = 1 - xAxis.renderer.cellStartLocation - (1 - xAxis.renderer.cellEndLocation);
    if (series.dataItems.length > 1) {
        var x0 = xAxis.getX(series.dataItems.getIndex(0), "categoryX");
        var x1 = xAxis.getX(series.dataItems.getIndex(1), "categoryX");
        var delta = ((x1 - x0) / chart.series.length) * w;
        if (am4core.isNumber(delta)) {
            var middle = chart.series.length / 2;

            var newIndex = 0;
            chart.series.each(function(series) {
                if (!series.isHidden && !series.isHiding) {
                    series.dummyData = newIndex;
                    newIndex++;
                }
                else {
                    series.dummyData = chart.series.indexOf(series);
                }
            })
            var visibleCount = newIndex;
            var newMiddle = visibleCount / 2;

            chart.series.each(function(series) {
                var trueIndex = chart.series.indexOf(series);
                var newIndex = series.dummyData;

                var dx = (newIndex - trueIndex + middle - newMiddle) * delta

                series.animate({ property: "dx", to: dx }, series.interpolationDuration, series.interpolationEasing);
                series.bulletsContainer.animate({ property: "dx", to: dx }, series.interpolationDuration, series.interpolationEasing);
            })
        }
    }
}

}); // end am4core.ready()


$(document).ready(function() {
 var ClassesGranCount="<?=$_SESSION['ClassesGranCount'];?>";
var UsersGranCount="<?=$_SESSION['UsersGranCount'];?>";
//обновление шапки(количества)
//классы
$("#colgranclass").empty();
  $("#colgranclass").append("Количество классов/групп: "+ClassesGranCount);
  
  //тестируемые
  $("#colgranuser").empty();
  $("#colgranuser").append("Количество тестируемых: "+UsersGranCount+" чел.");
});

</script>
  <meta charset="UTF-8">
  <!-- Прелоадер -->
  <div class="preloader">
    <div class="preloader__row">
      <div class="preloader__item"></div>
      <div class="preloader__item"></div>
    </div>
  </div>
  <title>Определение границ</title>
  
  
  
      <link rel="stylesheet" href="../../css/viewgran.css?v=1">

  
</head>

<body>
<body {
section {position: absolute;
        top: 50%;
        left: 50%;
        margin-right: -50%;
        transform: translate(-50%, -50%) }}
>
<h2 align = center>Определение границ</H2>
<p>&nbsp;</p> 
<div class="container" >
	<section id="content" >
	

		<form name="form" > 
		
 <span id="colgranclass" style="margin-left: 20px;"></span> <span id="colgranuser" style="margin-left: 40px;"></span>		
 <p>&nbsp;</p> 
		<p>Тип границ: <b><?=$_SESSION['test_typerazchet'];?></b> </p>	
<div id="chartdiv"></div>


<div class="kek">
<input type="button" class="sub"  value="Назад в школу" onclick=" document.location.replace('adminclassschool.php');">
</div>

<div class="kek">
<input type="button" class="sub"  value="Назад в район" style="margin-left: 50px;" onclick=" document.location.replace('adminschool.php');">
</div>

		</form><!-- form -->
		
	</section><!-- content -->
</div><!-- container -->
<p>&nbsp;</p> 
<div class="exitright">
<input type="button" class="button4" Value="Выход" onclick=" document.location.replace('../../destroy.php');">
<p>&nbsp;</p> 
<div class="kek">
<input type="button"  type="button" class="button4" Value="Меню " style="background: #fff331f7 linear-gradient(#fff331f7, #c38832);" onclick=" document.location.replace('../admin.php');">
</div>
</div>
</body>
</html>
  
  
</body>
</html>