<?php

require_once 'src/classes/ConnectionFactory.php';

class RequeteCar
{

    private object $bdd;

    public function __construct()
    {
        ConnectionFactory::setConfig('dbData.ini'); //mettre le fichier de config à la racine du projet
        $this->bdd = ConnectionFactory::makeConnection();
    }

    /**
     * retourne sous forme de chaine de caractere tous les vehicules d'une categorie qui sont disponible pour une periode donnee
     * @param $cat
     * @param $dateDbt
     * @param $datef
     * @return string
     */
    public function listerVehicules($cat, $dateDbt, $datef) {
        $stm1 = $this->bdd->prepare("select distinct vehicule.no_imm, vehicule.modele from calendrier, vehicule where vehicule.no_imm = calendrier.no_imm and (datejour between str_to_date(?,'%Y-%m-%d') and str_to_date(?,'%Y-%m-%d')) and vehicule.no_imm IN (select no_imm from vehicule where code_categ = ?)");
        $stm1->bindParam(1, $dateDbt);
        $stm1->bindParam(2, $datef);
        $stm1->bindParam(3, $cat);
        $stm1->execute();
        $str = "";
        while ($donnees = $stm1->fetch(PDO::FETCH_ASSOC)) {
            $str .= "Le vehicule " . $donnees['no_imm'] . " de modele " . $donnees['modele'] . " est disponible</br>";
        }
        return $str;
    }
    public function updateCalendrier($imm,$datedbt,$datef){
        $stm1 = $this->bdd->prepare("UPDATE Calendrier SET paslibre = 'x' WHERE no_imm = :imm AND datejour BETWEEN TO_DATE(:datedbt,'DD/MM/YYYY') AND TO_DATE(:datefin,'DD/MM/YYYY')"
        );
        $stm1->bindParam(':imm', $imm);
        $stm1->bindParam(':datedbt', $_POST['dateDbt']);
        $stm1->bindParam(':datefin', $_POST['datef']);
        try {
            $stm1->execute();
            $str='bien inseré';
        } catch (Exception $e) {
            $str= "pas inséré";
        }
        return $str;
    }
}





















