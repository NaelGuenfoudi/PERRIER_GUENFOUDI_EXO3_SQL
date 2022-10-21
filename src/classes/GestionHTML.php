<?php

require_once 'src/classes/RequeteCar.php';

class GestionHTML {
    public static function menu() : string {
        return
            '<form name="f1" action="" method="get">
                <select name="action" onchange="this.form.submit()">
                    <option value="SELECTION">selection</option>
                    <option value="requete 1">requete 1
                    </option>
                    <option value="requete 2">requete 2
                    </option>
                    <option value="requete 3">requete 3
                    </option>
                    <option value="requete 4">requete 4
                    </option>
                    <option value="requete 5">requete 5
                    </option>
                </select>
            </form>';
    }

    public static function questionnaire1() {
        $rqtCar = new RequeteCar();

        $stm11 = $rqtCar->listerCategories();
        $retour = "<form method='post'><label>Categorie de véhicule: </label><select name='cat' id='cat' required>";
        while ($data = $stm11->fetch(PDO::FETCH_ASSOC)) {
            $val = $data['code_categ'];
            $retour .= "<option value='$val'>$val</option>"; // choix du libelle
        }
        $retour .= "</select><br>";

        $retour .= '<p>date debut location : <input type="date" name="dateD" /></p>
                       <p>date fin location :<input type="date" name="dateF"</p>
                       <p><input type="submit" value="OK"></p>
                       </form>';
        return $retour;
    }

    public static function questionnaire2() {
        $rqtCar = new RequeteCar();
        $stm21 = $rqtCar->listerImmatriculations();
        $retour = "<form method='post'><label>Immatriculation du vehicule : </label><select name='no_imm' id='no_imm' required>";
        while ($data = $stm21->fetch(PDO::FETCH_ASSOC)) {
            $val = $data['no_imm'];
            $retour .= "<option value='$val'>$val</option>"; // choix du libelle
        }
        $retour .= "</select><br>";
        $retour .= '<p>date debut location : <input type="date" name="dateDbt" /></p>
                       <p>date fin location :<input type="date" name="datef"</p>
                       <p><input type="submit" value="OK"></p>
                       </form>';
        return $retour;
    }

    public static function questionnaire3() {
        $rqtCar = new RequeteCar();
        $stm31 = $rqtCar->listerModeles();
        $retour = "<form method='post'><label>Immatriculation du vehicule : </label><select name='modele' id='modele' required>";
        while ($data = $stm31->fetch(PDO::FETCH_ASSOC)) {
            $val = $data['modele'];
            $retour .= "<option value='$val'>$val</option>"; // choix du libelle
        }
        $retour .= "</select><br>";
        $retour .= '<p>Nombre de jours : <input type="number" name="nbJours"</p>
                       <p><input type="submit" value="OK"></p>
                       </form>';
        return $retour;
    }

    public static function accueil() {
        return "<h2>Bonjour et bienvenue sur notre rendu de l'exercice 3 du TP 4 !</h2><p>Ce TP a été réalisé par Rémi Perrier et Naël Guenfoudi</p>";
    }
}