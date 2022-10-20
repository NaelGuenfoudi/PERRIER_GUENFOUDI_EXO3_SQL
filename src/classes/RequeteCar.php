<?php

namespace questionnaire;
class RequeteCar
{

    private $bdd;

    public function __construct($bddP)
    {
        $this->bdd = $bddP;
    }

    /**
     * retourne sous forme de chaine de caractere tous les vehicules d'une categorie qui sont disponible pour une periode donnee
     * @param $cat
     * @param $dateDbt
     * @param $datef
     * @return string
     */
    public function listerVehicules($cat, $dateDbt, $datef)
    {
        $stm1 = $this->bdd->prepare("SELECT DISTINCT v.no_imm as imm,v.modele as mod FROM Vehicule v, Categorie ca 
                WHERE v.code_categ = ca.code_categ 
                   AND ca.libelle LIKE :categorie
                   AND no_imm NOT IN (SELECT DISTINCT no_imm FROM Calendrier 
                WHERE paslibre LIKE 'x' 
            AND datejour BETWEEN :datedbt AND :datefin)");
        $stm1->bindParam(':categorie', $cat);
        $stm1->bindParam(':datedbt', $dateDbt);
        $stm1->bindParam(':datefin', $datef);
        $stm1->execute();
        while ($donnees = $stm1->fetch(PDO::FETCH_ASSOC)) {
            $str .= "Le vehicule " . $donnees['imm'] . " de modele " . $donnees['mod'] . " est disponible";
        }
        return $str;
    }
}





















