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

$rqtCar = new RequeteCar();
switch ($page) {
    case 'quest1':
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {

            $retour = $rqtCar->listerCategories();

            $retour .= '<p>date debut location : <input type="date" name="dateD" /></p>
                       <p>date fin location :<input type="date" name="dateF"</p>
                       <p><input type="submit" value="OK"></p>
                       </form>';
        } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $retour = $rqtCar->listerVehicules($_POST['cat'], $_POST['dateD'], $_POST['dateF']);
        }
        break;

    case 'quest2':
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {

            $retour = $rqtCar->listerImmatriculations();

            $retour .= '<p>date debut location : <input type="date" name="dateDbt" /></p>
                       <p>date fin location :<input type="date" name="datef"</p>
                       <p><input type="submit" value="OK"></p>
                       </form>';
        } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $rqtCar->updateCalendrier($_POST['immat'],$_POST['dateDbt'],$_POST['datef']);//renvoie juste bien inserer , si c'est le cas
        }
        break;

    case 'quest3':
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $retour = $rqtCar->listerModeles();
            $retour .= '<p>Nombre de jours :<input type="number" name="nbJours"</p>
                       <p><input type="submit" value="OK"></p>
                       </form>';
        } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $retour = $rqtCar->calculerPrix($_POST['modele'], $_POST['nbJours']);
        }
        break;

    case 'quest4':
        $retour = $rqtCar->agencesAvecToutesCategories();
        break;

    case 'quest5':
        $retour = $rqtCar->clients2Modeles();
        break;

    default:
        $retour = 'Bienvenue !';
}
echo $retour;// il faut que tu recupere ça et que tu le fous dans le code html
?>