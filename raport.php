<?php
session_start();

if(!isset($_SESSION['zalogowany']))
{
    header('Location:index.php');
}

?>


<?php
	$ok=false;
	$edane1=str_replace(",",".",$_POST['dane1']??"");
	$edane2=str_replace(",",".",$_POST['dane2']??"");
	$edane3=str_replace(",",".",$_POST['dane3']??"");
	$edane4=str_replace(",",".",$_POST['dane4']??"");

	echo $edane4;

	if (isset($_POST['dane1']))
	{
		$ok=true;

		//walidacja pola nr 1
		
		if ((($_POST['dane1'])=="") || (($_POST['dane2'])=="") || (($_POST['dane3'])=="") || (($_POST['dane4'])==""))
		{
			$ok=false;
            $_SESSION['dane1']="Wszystkie cztery kolumny muszą byc wypełnione";	
		}
	else
	{
		if(($edane1 > 999999))
		{
			$ok=false;
            $_SESSION['dane1']="W pierwszych dwóch polach liczba nie może być większa od 999 999";
		}
		if(($edane1 < 0))
		{
			$ok=false;
            $_SESSION['dane1']="W pierwszych trzech polach liczba musi być większa bądź równa zero";
		}
		if((is_numeric($edane1))==false)
		{
			$ok=false;
            $_SESSION['dane1']="Dozwolone są tylko cyfry, przecinek lub kropka";		
		}
	
		

		//walidacja pola nr 2
		if(($edane2 > 999999))
		{
			$ok=false;
            $_SESSION['dane1']="W pierwszych dwóch polach liczba nie może być większa od 999 999";
		}
		if(($edane2 < 0))
		{
			$ok=false;
            $_SESSION['dane1']="W pierwszych trzech polach liczba musi być większa bądź równa zero";
		}
		if((is_numeric($edane2))==false)
		{
			$ok=false;
            $_SESSION['dane1']="Dozwolone są tylko cyfry, przecinek lub kropka";
			
		}
	
		


		//walidacja pola nr 3
		if (($edane3 < 0))
        {
            $ok=false;
            $_SESSION['dane1']="W pierwszych trzech polach liczba musi być większa bądź równa zero";
        }
		if (($edane3 > 9999))
        {
            $ok=false;
            $_SESSION['dane3']="maksymalna liczba w trzeciej kolumnie to 9999";
        }
		if((is_numeric($edane3))==false)
		{
			$ok=false;
            $_SESSION['dane3']="Dozwolone są tylko cyfry, przecinek lub kropka";
		}
		
		

		//walidacja pola nr 4
		if (((is_numeric($edane4))==true) && ($edane4 < -20))
        {
            $ok=false;
            $_SESSION['dane4']="Deflacja nie może być mniejsza od -20%";
        }
		if (((is_numeric($edane4))==true) && ($edane4 > 20))
        {
            $ok=false;
            $_SESSION['dane4']="Inflacja nie może być większa od 20%";
        }
		if ((is_numeric($edane4))==false)
		{
			$ok=false;
            $_SESSION['dane1']="Dozwolone są tylko cyfry, przecinek lub kropka";
		}
		
	}

/*
		if($ok==true)
		{
			echo "<b>Udana walidacja</b>";
			//dane są poprawne
		}
*/		
	}
	
	?>


<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1"/>
<link rel="stylesheet" href="style.css" type="text/css"/>
<link href='http://fonts.googleapis.com/css?family=Lato:400,900&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
<title>Raport pomagający zaplanować swój sposób oszczędzania</title>

<style>
	.error
	{
		color:red;
		margin-top: 10px;
		margin-bottom: 10px;
	}
</style>

</head>

<body>
<div id="container">
<div id="logo">
        Program do przeprowadzenia analizy finansowej na 40 lat!
    </div>

    <div id="menu">
		<div class="option"><a href="index.php">Strona główna</a></div>
        <div class="option"><a href="kontakt.php">Kontakt</a></div>
        <div class="option">Film</div>
		<div id="optionraport"> <a href="logout.php">Wyloguj się!</a> </div>
        <div style="clear:both;"></div>
		
    </div>



    <div id="topbar">

    <div id="topbarL">
        <img src="ff06.png"/>
    </div>

    <div id="topbarR">
        <h1 style="font-size:35px; margin-top:-10px; margin-bottom:-10px;"> O projekcie  </h1><br/>
        <div style="font-size:20px;"> Projekt powstał aby ułatwić zaplanowanie 
        swojego stylu oszczędzania, aby możliwie jak najlepiej zaplanować finansowo 
        swoją przyszłość. Dlatego też raport zawiera wykres aby pokazać graficznie jak 
        oprocentowanie oraz podatek inflacyjny wpływa na wartość pieniądza w czasie.
        </div>
    </div>
    <div style="clear:both;"></div>
    </div>


		<div id="contentraport">

<form action="raport.php" method="post">

<h2> Wprowadź dane </h2>

<?php
echo "<p>Witaj ".$_SESSION['user']//.'![ <a href="logout.php">Wyloguj się!</a> ]</p>';
//echo "<p>Witaj ".$_SESSION['user'].'![ <a href="logout.php">Wyloguj się!</a> ]</p>';
?>

<table border="1" cellpadding="4" cellspacing="0">

<tr>
		<td> kwota wpłacana na <br/> początek </td>
        <td> dodatkowy kapitał <br/> wpłacany co roku </td>
        <td> roczna stopa <br/> oprocentowania </td>
        <td> zakładana roczna <br/> inflacja </td>
	</tr>
	<tr>
		<td> <input type="text" name="dane1" size="14" value="<?php if(isset($_POST['dane1'])) {echo $_POST['dane1'];} ?>" placeholder="np. 10000" autofocus/> zł. </td>
        <td> <input type="text" name="dane2" size="14" value="<?php if(isset($_POST['dane2'])) {echo $_POST['dane2'];} ?>" placeholder="np. 10000"/> zł.</td>
        <td> <input type="text" name="dane3" size="14" value="<?php if(isset($_POST['dane3'])) {echo $_POST['dane3'];} ?>" placeholder="np. 5"/> % </td>
        <td> <input type="text" name="dane4" size="14" value="<?php if(isset($_POST['dane4'])) {echo $_POST['dane4'];} ?>" placeholder="np. 2.5"/> % </td> 
	</tr>	
	
	<?php
		if(isset($_SESSION['dane1']))
		{
			echo '<div class="error">'.$_SESSION['dane1'].'</div>';
			unset($_SESSION['dane1']);
		}
	?>

	<?php
		if(isset($_SESSION['dane3']))
		{
			echo '<div class="error">'.$_SESSION['dane3'].'</div>';
			unset($_SESSION['dane3']);
		}
	?>

	<?php
		if(isset($_SESSION['dane4']))
		{
			echo '<div class="error">'.$_SESSION['dane4'].'</div>';
			unset($_SESSION['dane4']);
		}
	?>




</table>

<br/>
<input type="submit" value="Zatwierdź"/> 
<br/><br/>
</form>



<?php
if($ok==true)
{
$dane1=str_replace(",",".",$_POST['dane1']??"");
$dane2=str_replace(",",".",$_POST['dane2']??"");
$dane3=str_replace(",",".",$_POST['dane3']??"");
$dane4=str_replace(",",".",$_POST['dane4']??"");

$belka=0.81;
$k1=$dane1;
$k2=0;
$k3=0;
$k4=0;
$k5=0;
$k6=0;
$k7=0;
$k8=0;
$k9=0;
$k10=0;

$tablicak1=array();
$tablicak2=array();
$tablicak3=array();
$tablicak4=array();
$tablicak5=array();
$tablicak6=array();
$tablicak7=array();
$tablicak8=array();
$tablicak9=array();
$tablicak10=array();

for($i=1; $i<=40; $i++)
{
	if($i==1) 
	{
		$tablicak1[$i]=$dane1; 
		$tablicak2[$i]=(1+($dane3/100))*$tablicak1[$i];
		$tablicak8[$i]=$tablicak1[$i]*($dane3/100);
	}
	else 
	{
		$tablicak1[$i]=$tablicak1[$i-1]+$dane2;
		$tablicak2[$i]=($tablicak2[$i-1]+$dane2)*(1+($dane3/100));
		$tablicak8[$i]=($tablicak1[$i]+$tablicak3[$i-1])*($dane3/100);
	}
	$tablicak3[$i]=$tablicak2[$i]-$tablicak1[$i];
	$tablicak4[$i]=$tablicak3[$i]*$belka;
	$tablicak5[$i]=$tablicak1[$i]+$tablicak4[$i];
	$tablicak6[$i]=$tablicak3[$i]-$tablicak4[$i];
	$tablicak7[$i]=$tablicak3[$i]/12;
	$tablicak9[$i]=$tablicak2[$i]*(pow((1-($dane4/100)),$i));
	$tablicak10[$i]=($tablicak1[$i]+($tablicak3[$i]*$belka))*pow((1-($dane4/100)),$i);
}

//var_dump($tablicak10);


$dataPoints1=array();
$dataPoints2=array();
$dataPoints3=array();
$dataPoints4=array();

for($i = 0; $i<40; $i++)
{ 
	$dataPoints1[$i]=array("label"=> $i+1 , "y"=> $tablicak1[$i+1]);
	$dataPoints2[$i]=array("label"=> $i+1 , "y"=> $tablicak2[$i+1]);
	$dataPoints3[$i]=array("label"=> $i+1 , "y"=> $tablicak5[$i+1]);
	$dataPoints4[$i]=array("label"=> $i+1 , "y"=> $tablicak9[$i+1]);
}


}
?>



<head> 
<link rel="stylesheet" href="style.css" type="text/css"/>
<link href='http://fonts.googleapis.com/css?family=Lato:400,900&subset=latin,latin-ext' rel='stylesheet' type='text/css'> 
<script>
window.onload = function () {
 
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	theme: "light2",
	title:{
		text: "WYKRES"
	},
	axisY:{
		includeZero: true
	},
	legend:{
		cursor: "pointer",
		verticalAlign: "center",
		horizontalAlign: "right",
		itemclick: toggleDataSeries
	},
	data: [{
		type: "column",
		color: "	#696969",
		name: "wpłacona kwota",
		//indexLabel: "{y}",
		yValueFormatString: "### ### ### ### ###zł",
		showInLegend: true,
		dataPoints: <?php echo json_encode($dataPoints1, JSON_NUMERIC_CHECK); ?>
	},{
		type: "column",
		color: "#3CB371",
		name: "kwota po oprocentowaniu",
		//indexLabel: "{y}",
		yValueFormatString: "### ### ### ### ###zł",
		showInLegend: true,
		dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
	},{
		type: "line",
		color: "#0000CD",
		name: "kwota po oprocentowaniu z uwzględnieniem podatku (belki)",
		//indexLabel: "{y}",
		yValueFormatString: "### ### ### ### ###zł",
		showInLegend: true,
		dataPoints: <?php echo json_encode($dataPoints3, JSON_NUMERIC_CHECK); ?>
	},{
		type: "line",
		color:"red",
		name: "wartość konta po uwzględnieniu inflacji",
		//indexLabel: "{y}",
		yValueFormatString: "### ### ### ### ###zł",
		showInLegend: true,
		dataPoints: <?php echo json_encode($dataPoints4, JSON_NUMERIC_CHECK); ?>
		
	}
	
	
	]
});
chart.render();

function toggleDataSeries(e){
	if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
		e.dataSeries.visible = false;
	}
	else{
		e.dataSeries.visible = true;
	}
	chart.render();
}
 
}
</script>
</head>
<body>
<div id="chartContainer" style="height: 470px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>








<?php
//value="10000"

if($ok==true)
{

echo<<<END

	<h2>Raport</h2>

	<table border="4" cellpadding="4" cellspacing="1">
	<tr style="background-color:#9BC2E6;">
		<td> Lata </td>
        <td style="text-align:center; color:#696969; font-weight:900;"> wpłacona kwota na konto</td>
        <td style="text-align:center; color:#3CB371; font-weight:900;"> kwota po <br/> uwzględnieniu <br/> oprocentowania </td>
        <td style="text-align:center;"> zysk względem <br/> kwoty zainwestowanej </td> 
        <td style="text-align:center;"> zysk po uwzględnieniu <br/> belki 19% </td>
        <td style="text-align:center; color:#0000CD; font-weight:900;"> łączne saldo konta po <br/> uwzględnieniu belki (19%) </td>
        <td style="text-align:center;"> kwota podatku belki (19%) <br/> jaką trzeba zapłacić <br/> w przypadku <br/>  przedwczesnej wypłaty </td>
        <td style="text-align:center;"> miesięczna kwota z <br/> rocznych odsetek  </td>
        <td style="text-align:center;"> roczny zysk na podstawie <br/> założonego oprocentowania  </td>
        <td style="text-align:center; color:red; font-weight:900;"> łączna wartość salda <br/> konta po uwzględnieniu <br/> inflacji za X lat </td>
        <td style="text-align:center;"> łączna wartość salda <br/> konta po uwzględnieniu <br/> inflacji za X lat z<br/> odprowadzeniem podatku </td>
	</tr>
    
END;




for($i=1; $i<=40; $i++)
{


$f1=number_format($tablicak1[$i], 0, ',', ' ');
$f2=number_format($tablicak2[$i], 0, ',', ' ');
$f3=number_format($tablicak3[$i], 0, ',', ' ');
$f4=number_format($tablicak4[$i], 0, ',', ' ');
$f5=number_format($tablicak5[$i], 0, ',', ' ');
$f6=number_format($tablicak6[$i], 0, ',', ' ');
$f7=number_format($tablicak7[$i], 0, ',', ' ');
$f8=number_format($tablicak8[$i], 0, ',', ' ');
$f9=number_format($tablicak9[$i], 0, ',', ' ');
$f10=number_format($tablicak10[$i], 0, ',', ' ');

    echo<<<END
	
    <tr>
        <td> $i </td>
        <td style="background-color:#BFBFBF;"> $f1 zł </td>
        <td style="background-color:#A9D08E;"> $f2 zł </td>
        <td> $f3 zł </td>
        <td> $f4 zł </td>
        <td style="background-color:#62A0D8;"> $f5 zł </td>
        <td> $f6 zł </td>
        <td> $f7 zł </td>
        <td> $f8 zł </td>
        <td style="background-color:#FF9B9B;"> $f9 zł </td>
        <td> $f10 zł </td>
	</tr>
	
END;

}
echo '</table>';
	
    
    
}
?>
<br/>
<div> <a style="color:black;" href="raport.php">Wyczyść raport</a></div>
		</div>

	<div id="footer">
    Poznaj swoje możliwości! Zaplanuj swoją przyszłość!  &copy; wszelkie prawa zastrzeżone 
    </div>

</div>

</body>










</html>