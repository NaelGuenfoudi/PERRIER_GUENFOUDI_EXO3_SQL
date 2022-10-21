<?php

require_once 'src/classes/RequeteCar.php';
require_once 'src/classes/GestionHTML.php';

$page = null;
if (isset($_GET['action'])) {
    $page = $_GET['action'];
}

echo GestionHTML::menu();

$rqtCar = new RequeteCar();
switch ($page) {
    case 'requete 1':
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            echo GestionHTML::questionnaire1();
        } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            echo $rqtCar->requete1($_POST['cat'], $_POST['dateD'], $_POST['dateF']);
        }
        break;

    case 'requete 2':
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            echo GestionHTML::questionnaire2();
        } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            echo $rqtCar->requete2($_POST['no_imm'],$_POST['dateDbt'],$_POST['datef']);
        }
        break;

    case 'requete 3':
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            echo GestionHTML::questionnaire3();
        } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            echo $rqtCar->requete3($_POST['modele'], $_POST['nbJours']);
        }
        break;

    case 'requete 4':
        echo $rqtCar->requete4();
        break;

    case 'requete 5':
        echo $rqtCar->requete5();
        break;

    default:
        echo GestionHTML::accueil();
}


?>