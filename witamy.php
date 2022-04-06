<?php
 
    session_start();
     
    if (!isset($_SESSION['udanarejestracja']))
    {
        header('Location: index.php');
        exit();
    }
    else
    {
        unset($_SESSION['udanarejestracja']);
    }
     
    //Usuwanie zmiennych pamiętających wartości wpisane do formularza
    if (isset($_SESSION['fr_nick'])) unset($_SESSION['fr_nick']);
    if (isset($_SESSION['fr_email'])) unset($_SESSION['fr_email']);
    if (isset($_SESSION['fr_haslo1'])) unset($_SESSION['fr_haslo1']);
    if (isset($_SESSION['fr_haslo2'])) unset($_SESSION['fr_haslo2']);
    if (isset($_SESSION['fr_regulamin'])) unset($_SESSION['fr_regulamin']);
     
    //Usuwanie błędów rejestracji
    if (isset($_SESSION['e_nick'])) unset($_SESSION['e_nick']);
    if (isset($_SESSION['e_email'])) unset($_SESSION['e_email']);
    if (isset($_SESSION['e_haslo'])) unset($_SESSION['e_haslo']);
    if (isset($_SESSION['e_regulamin'])) unset($_SESSION['e_regulamin']);
    if (isset($_SESSION['e_bot'])) unset($_SESSION['e_bot']);
     
?>
 
<!DOCTYPE HTML>
<html lang="pl">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <link rel="stylesheet" href="style.css" type="text/css"/>
    <link href='http://fonts.googleapis.com/css?family=Lato:400,900&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <title>Raport finansowy</title>
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





<div id="sidebar">

    <div class="optionL">
        <a href="index.php">Zaloguj się</a>
    </div>
    <div style="clear:both;"></div>

</div>



<div id="content">



    
    <b>Dziękujemy za rejestrację w serwisie! Możesz już zalogować się na swoje konto!</b><br /><br />
     
   
 
</div>



<div id="footer">
    Poznaj swoje możliwości! Zaplanuj swoją przyszłość!  &copy; wszelkie prawa zastrzeżone 
</div>


</div>
</body>
</html>