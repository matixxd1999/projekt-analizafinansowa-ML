<?php
 
    session_start();
     
    if (isset($_POST['email']))
    {
        //Udana walidacja? Załóżmy, że tak!
        $wszystko_OK=true;
         
        //Sprawdź poprawność nickname'a
        $nick = $_POST['nick'];
         
        //Sprawdzenie długości nicka
        if ((strlen($nick)<3) || (strlen($nick)>20))
        {
            $wszystko_OK=false;
            $_SESSION['e_nick']="Nick musi posiadać od 3 do 20 znaków!";
        }
         
        if (ctype_alnum($nick)==false)
        {
            $wszystko_OK=false;
            $_SESSION['e_nick']="Nick może składać się tylko z liter i cyfr (bez polskich znaków)";
        }
         
        // Sprawdź poprawność adresu email
        $email = $_POST['email'];
        $emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
         
        if ((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) || ($emailB!=$email))
        {
            $wszystko_OK=false;
            $_SESSION['e_email']="Podaj poprawny adres e-mail!";
        }
         
        //Sprawdź poprawność hasła
        $haslo1 = $_POST['haslo1'];
        $haslo2 = $_POST['haslo2'];
         
        if ((strlen($haslo1)<8) || (strlen($haslo1)>20))
        {
            $wszystko_OK=false;
            $_SESSION['e_haslo']="Hasło musi posiadać od 8 do 20 znaków!";
        }
         
        if ($haslo1!=$haslo2)
        {
            $wszystko_OK=false;
            $_SESSION['e_haslo']="Podane hasła nie są identyczne!";
        }   
 
        $haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);
         
        //Czy zaakceptowano regulamin?
        if (!isset($_POST['regulamin']))
        {
            $wszystko_OK=false;
            $_SESSION['e_regulamin']="Potwierdź akceptację regulaminu!";
        }               
         
        //Czy jesteś botem ?
        $sekret = "6LdiWmcaAAAAACAAyuoCP8daT-7yoLItk4cJxId9";
         
        $sprawdz = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$sekret.'&response='.$_POST['g-recaptcha-response']);
         
        $odpowiedz = json_decode($sprawdz);
         
        if ($odpowiedz->success==false)
        {
            $wszystko_OK=false;
            $_SESSION['e_bot']="Potwierdź, że nie jesteś botem!";
        }       
         
        //Zapamiętaj wprowadzone dane
        $_SESSION['fr_nick'] = $nick;
        $_SESSION['fr_email'] = $email;
        $_SESSION['fr_haslo1'] = $haslo1;
        $_SESSION['fr_haslo2'] = $haslo2;
        if (isset($_POST['regulamin'])) $_SESSION['fr_regulamin'] = true;
         
        require_once "connect.php";
        mysqli_report(MYSQLI_REPORT_STRICT);
         
        try
        {
            $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
            if ($polaczenie->connect_errno!=0)
            {
                throw new Exception(mysqli_connect_errno());
            }
            else
            {
                //Czy email już istnieje?
                $rezultat = $polaczenie->query("SELECT id FROM uzytkownicy WHERE email='$email'");
                 
                if (!$rezultat) throw new Exception($polaczenie->error);
                 
                $ile_takich_maili = $rezultat->num_rows;
                if($ile_takich_maili>0)
                {
                    $wszystko_OK=false;
                    $_SESSION['e_email']="Istnieje już konto przypisane do tego adresu e-mail!";
                }       
 
                //Czy nick jest już zarezerwowany?
                $rezultat = $polaczenie->query("SELECT id FROM uzytkownicy WHERE user='$nick'");
                 
                if (!$rezultat) throw new Exception($polaczenie->error);
                 
                $ile_takich_nickow = $rezultat->num_rows;
                if($ile_takich_nickow>0)
                {
                    $wszystko_OK=false;
                    $_SESSION['e_nick']="Istnieje już gracz o takim nicku! Wybierz inny.";
                }
                 
                if ($wszystko_OK==true)
                {
                    //Hurra, wszystkie testy zaliczone, dodajemy gracza do bazy
                     
                    if ($polaczenie->query("INSERT INTO uzytkownicy VALUES (NULL, '$nick', '$haslo_hash', '$email')"))
                    {
                        $_SESSION['udanarejestracja']=true;
                        header('Location: witamy.php');
                    }
                    else
                    {
                        throw new Exception($polaczenie->error);
                    }
                     
                }
                 
                $polaczenie->close();
            }
             
        }
        catch(Exception $e)
        {
            echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
            echo '<br />Informacja developerska: '.$e;
        }
         
    }
     
     
?>
 
<!DOCTYPE HTML>
<html lang="pl">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Aby wykonać raport - załóż darmowe konto!</title>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <link rel="stylesheet" href="style.css" type="text/css"/>
    <link href='http://fonts.googleapis.com/css?family=Lato:400,900&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
     
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
    <div class="optionLregister">
    <a href="index.php">Powrót do strony logowania</a>
    </div>
    </div>

    <div id="content">
    <form method="post">
     
        <b>Tutaj możesz założyć konto całkowicie za darmo!!! <br/>
            Nie przegap tej okazji !!!</b><br/><br/>

        Nickname: <br /> <input type="text" value="<?php
            if (isset($_SESSION['fr_nick']))
            {
                echo $_SESSION['fr_nick'];
                unset($_SESSION['fr_nick']);
            }
        ?>" name="nick" /><br />
         
        <?php
            if (isset($_SESSION['e_nick']))
            {
                echo '<div class="error">'.$_SESSION['e_nick'].'</div>';
                unset($_SESSION['e_nick']);
            }
        ?>
         
        E-mail: <br /> <input type="text" value="<?php
            if (isset($_SESSION['fr_email']))
            {
                echo $_SESSION['fr_email'];
                unset($_SESSION['fr_email']);
            }
        ?>" name="email" /><br />
         
        <?php
            if (isset($_SESSION['e_email']))
            {
                echo '<div class="error">'.$_SESSION['e_email'].'</div>';
                unset($_SESSION['e_email']);
            }
        ?>
         
        Twoje hasło: <br /> <input type="password"  value="<?php
            if (isset($_SESSION['fr_haslo1']))
            {
                echo $_SESSION['fr_haslo1'];
                unset($_SESSION['fr_haslo1']);
            }
        ?>" name="haslo1" /><br />
         
        <?php
            if (isset($_SESSION['e_haslo']))
            {
                echo '<div class="error">'.$_SESSION['e_haslo'].'</div>';
                unset($_SESSION['e_haslo']);
            }
        ?>       
         
        Powtórz hasło: <br /> <input type="password" value="<?php
            if (isset($_SESSION['fr_haslo2']))
            {
                echo $_SESSION['fr_haslo2'];
                unset($_SESSION['fr_haslo2']);
            }
        ?>" name="haslo2" /><br />
         
        <label>
            <input type="checkbox" name="regulamin" <?php
            if (isset($_SESSION['fr_regulamin']))
            {
                echo "checked";
                unset($_SESSION['fr_regulamin']);
            }
                ?>/> Akceptuję regulamin
        </label>
         
        <?php
            if (isset($_SESSION['e_regulamin']))
            {
                echo '<div class="error">'.$_SESSION['e_regulamin'].'</div>';
                unset($_SESSION['e_regulamin']);
            }
        ?>   
         
        <div class="g-recaptcha" data-sitekey="6LdiWmcaAAAAAJ-gYp_X94rbAXjZX0q4Q62w1SZS"></div>
         
        <?php
            if (isset($_SESSION['e_bot']))
            {
                echo '<div class="error">'.$_SESSION['e_bot'].'</div>';
                unset($_SESSION['e_bot']);
            }
        ?>   
         
        <br />
         
        <input type="submit" value="Zarejestruj się" />
         
    </form>
    <div id="homemoneyregister">
            <img src="ff08.jpg"/>
        </div>

    </div>
 
    <div id="footer">
    Poznaj swoje możliwości! Zaplanuj swoją przyszłość!  &copy; wszelkie prawa zastrzeżone 
    </div>

</div>
</body>
</html>