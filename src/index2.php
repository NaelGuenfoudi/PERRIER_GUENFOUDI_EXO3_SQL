<?php
try {
    $bdd = new PDO('mysql:host=localhost;dbname=locationCar;charset=utf8', 'root', 'Nadog54244');
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
        </option>
        <option value="add-podcasttrack"<?php if ($page == "add-podcasttrack") {
            echo " selected";
        } ?>>add podcast
        </option>
    </select>
</form>

<?php
$retour = "";
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
            $stm1 = $bdd->prepare("SELECT DISTINCT v.no_imm,v.modele FROM Vehicule v, Categorie ca 
                WHERE v.code_categ = ca.code_categ 
                   AND ca.libelle LIKE :categorie
                   AND no_imm NOT IN (SELECT DISTINCT no_imm FROM Calendrier 
                WHERE paslibre LIKE 'x' 
            AND datejour BETWEEN :datedbt AND :datefin)");
            $stm1->bindParam(':categorie', $_POST['cat']);
            $stm1->bindParam(':datedbt', $_POST['dateDbt']);
            $stm1->bindParam(':datefin', $_POST['datef']);
            $stm1->execute();
            while ($data = $stm1->fetch()) {
                echo $data[0] . ";" . $data[1];
            }

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
    case 'add-podcasttrack':
        break;
    default:
        $retour = 'Bienvenue !';
}
echo $retour;
?>
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        

