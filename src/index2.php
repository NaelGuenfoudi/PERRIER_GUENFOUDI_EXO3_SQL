<?php

use questionnaire\RequeteCar;

try {

    $config = parse_ini_file('../dbData.ini'); //mettre le fichier de config à la racine du projet
    $driver = $config['driver'];
    $host = $config['host'];
    $dbname = $config['dbname'];
    $dsn = "$driver:host=$host; dbname=" . $dbname;
    $username = $config['username'];
    $password = $config['password'];
    $bdd = new PDO($dsn, $username, $password);
} catch (Exception $e) {
    die('erreur: ' . $e->getMessage());
}

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
$rqtCar = new RequeteCar($bdd);
switch ($page) {
    case 'quest1':
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $retour = '<form action="index2.php?action=quest1" method="post">
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

            $retour .= '<form action="index2.php?action=quest1" method="post">
                       <p>date debut : <input type="date" name="dateDbt" /></p>
                       <p>date fin:<input type="date" name="datef"</p>
                       <p><input type="submit" value="OK"></p>
                       </form>';
        } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $stm1 = $bdd->prepare("UPDATE Calendrier SET paslibre = 'x' WHERE no_imm = :imm AND datejour BETWEEN TO_DATE(:datedbt,'DD/MM/YYYY') AND TO_DATE(:datefin,'DD/MM/YYYY')"
            );
            $stm1->bindParam(':imm', $_POST['immat']);
            $stm1->bindParam(':datedbt', $_POST['dateDbt']);
            $stm1->bindParam(':datefin', $_POST['datef']);
            try {
                $stm1->execute();
                echo "bonne insertion";
            } catch (Exception $e) {
                echo "pas inséré";
            }

        }
        break;
    case 'quest3':
        break;
    case 'quest4':
        break;
    case 'quest5':
        break;
    default:
        $retour = 'Bienvenue !';
}
echo $retour;
?>
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        

