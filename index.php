<?php

require_once 'src/classes/RequeteCar.php';
require_once 'src/classes/GestionHTML.php';
require_once 'src/classes/ConnectionFactory.php';



$page = null;
if (isset($_GET['action'])) {
    $page = $_GET['action'];
}
?>
    <form name="f1" action="" method="get">
        <select name="action" onchange="this.form.submit()">
            <option value="SELECTION">selection</option>
            <option value="quest1"<?php if ($page == "quest1") {
                echo " selected";
            } ?>>quest1
            </option>
            <option value="quest2"<?php if ($page == "quest2") {
                echo " selected";
            } ?>>quest2
            <option value="quest3"<?php if ($page == "quest3") {
                echo " selected";
            } ?>>quest3
            </option>
            <option value="quest4"<?php if ($page == "quest4") {
                echo " selected";
            } ?>>quest4
            </option>
            <option value="quest5"<?php if ($page == "quest5") {
                echo " selected";
            } ?>>quest5
            </option>
        </select>
    </form>
<?php

$retour = "";
$rqtCar = new RequeteCar();
switch ($page) {
    case 'quest1':
        // ELLE EST ENFIN RÉPARÉ LA REQUETE LÀ, TOUT MARCHE POUR LA 1, VICTOIRE
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $retour = '<form action="index.php?action=quest1" method="post">
                       <p>Categorie : <input type="text" name="cat" /></p>
                       <p>date debut : <input type="date" name="dateDbt" /></p>
                       <p>date fin:<input type="date" name="datef"</p>
                       <p><input type="submit" value="OK"></p>
                       </form>';
        } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $retour = $rqtCar->listerVehicules($_POST['cat'], $_POST['dateDbt'], $_POST['datef']);
        }
        break;
    case 'quest2':
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $retour = "<form method='post'><label>Categorie de véhicule: </label><select name='categorie' id='cat' required>";
            $result = $bdd->query("select libelle from categorie");
            while ($data = $result->fetch(PDO::FETCH_ASSOC)) {
                $val = $data['libelle'];
                $html .= "<option value='$val'>$val</option>"; // choix du libelle
            }
            $retour .= "</select><br>";

            $retour = '<form action="index.php?action=quest2" method="post">
                       <p>Categorie : <input type="text" name="cat" /></p>
                       <p>date debut : <input type="date" name="dateDbt" /></p>
                       <p>date fin:<input type="date" name="datef"</p>
                       <p><input type="submit" value="OK"></p>
                       </form>';
        } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $rqtCar->updateCalendrier($_POST['immat'],$_POST['dateDbt'],$_POST['datef']);//renvoie juste bien inserer , si c'est le cas
        }
        break;
    case 'quest3':
        break;
    case 'quest4':
        break;
    case 'quest5':
        break;
    case 'accueil' :
        echo "bienvenue dans l accueil";
        break;
    default:
        $retour = 'Bienvenue !';
}
echo $retour;// il faut que tu recupere ça et que tu le fous dans le code html
?>