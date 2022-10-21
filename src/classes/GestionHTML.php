<?php

class GestionHTML {
    public static function menu() : string {
        return
            '<form name="f1">
                <select name="action" onchange="this.form.submit()">
                    <option value="SELECTION">accueil</option>
                    <option value="quest1"
                    <?php if ($page == "quest1") {
                    echo " selected";
                    } ?> >quest1
                    <option value="quest2">question2
                    </option>
                    <option value="quest3">question3
                    </option>
                    <option value="quest4">question4
                    </option>
                    <option value="quest5">question5
                    </option>
                </select>
            </form>';
    }

    public function questionnaire1() {
        $rqtCar = new RequeteCar();
        $requete = $rqtCar->listerCategories();
        $retour = "<form method='post'><label>Categorie de véhicule: </label><select name='cat' id='cat' required>";
        while ($data = $requete) {
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
}