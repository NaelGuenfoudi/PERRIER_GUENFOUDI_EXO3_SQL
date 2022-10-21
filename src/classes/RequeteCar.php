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
    public function listerVehicules($cat, $dateD, $dateF) {
        $stm1 = $this->bdd->prepare("select distinct vehicule.no_imm, vehicule.modele from calendrier, vehicule 
                                                where vehicule.no_imm = calendrier.no_imm 
                                                  and (datejour between str_to_date(?,'%Y-%m-%d') and str_to_date(?,'%Y-%m-%d')) 
                                                  and (vehicule.no_imm IN (select no_imm from vehicule where code_categ = ?))");
        $stm1->bindParam(1, $dateD);
        $stm1->bindParam(2, $dateF);
        $stm1->bindParam(3, $cat);
        $stm1->execute();
        $str = "";
        while ($donnees = $stm1->fetch(PDO::FETCH_ASSOC)) {
            $str .= "Le vehicule " . $donnees['no_imm'] . " de modele " . $donnees['modele'] . " est disponible</br>";
        }
        return $str;
    }

    public function listerCategories() {
        $stm11 = $this->bdd->query("select code_categ from categorie");
//        return $stm11->fetch(PDO::FETCH_ASSOC);
        $retour = "<form method='post'><label>Categorie de véhicule: </label><select name='cat' id='cat' required>";
        while ($data = $stm11->fetch(PDO::FETCH_ASSOC)) {
            $val = $data['code_categ'];
            $retour .= "<option value='$val'>$val</option>"; // choix du libelle
        }
        $retour .= "</select><br>";
        return $retour;
    }


    public function updateCalendrier($no_imm,$dateD,$dateF){
        $requeteCheckLibre = "select paslibre from calendrier where (datejour between str_to_date(?,'%Y-%m-%d') and str_to_date(?,'%Y-%m-%d')) and no_imm = ?";
        $stm1a= $this->bdd->prepare($requeteCheckLibre);
        $stm1a->bindParam(1, $dateD);
        $stm1a->bindParam(2, $dateF);
        $stm1a->bindParam(3, $no_imm);
        $stm1a->execute();

        $flagToutLibre = true;

        while ($donnees = $stm1a->fetch(PDO::FETCH_ASSOC)) {
            if ($donnees['paslibre']!=null) {
                $flagToutLibre = false;
            } else {
            }
        }

        if ($flagToutLibre){
            $stm1b = $this->bdd->prepare("update calendrier set paslibre = 'x' where (datejour between str_to_date(?,'%Y-%m-%d') and str_to_date(?,'%Y-%m-%d')) and no_imm = ?");
            $stm1b->bindParam(1, $dateD);
            $stm1b->bindParam(2, $dateF);
            $stm1b->bindParam(3, $no_imm);
            $stm1b->execute();
            $retour = "la validation a bien été prise en compte";
        } else {
            $retour = "le véhicule n'est pas disponible sur la période demandée";
        }
        return $retour;
    }

    public function listerImmatriculations() {
        $stm21 = $this->bdd->query("select no_imm from vehicule");

        $retour = "<form method='post'><label>Immatriculation du vehicule : </label><select name='no_imm' id='no_imm' required>";
        while ($data = $stm21->fetch(PDO::FETCH_ASSOC)) {
            $val = $data['no_imm'];
            $retour .= "<option value='$val'>$val</option>"; // choix du libelle
        }
        $retour .= "</select><br>";

        return $retour;
    }


    public function calculerPrix($modele,$nbJours) {
        $stm3=$this->bdd->prepare("select tarif.tarif_jour, tarif.tarif_hebdo from tarif, vehicule, categorie where vehicule.modele = ? and categorie.code_categ = vehicule.code_categ and categorie.code_tarif = tarif.code_tarif");
        $stm3->bindParam(1,$modele);
        $stm3->execute();

        $retour = "";
        while ($donnees = $stm3->fetch(PDO::FETCH_ASSOC)) {
            $tarif = (($nbJours - ($nbJours%7))/7 * $donnees['tarif_hebdo'] + ($nbJours%7)*$donnees['tarif_jour']);
            $retour.= "La voiture $modele est au prix de $tarif"."€ pour une durée de $nbJours jours";
        }
        return $retour;
    }

    public function listerModeles() {
        $stm31 = $this->bdd->query("select modele from vehicule");

        $retour = "<form method='post'><label>Immatriculation du vehicule : </label><select name='modele' id='modele' required>";
        while ($data = $stm31->fetch(PDO::FETCH_ASSOC)) {
            $val = $data['modele'];
            $retour .= "<option value='$val'>$val</option>"; // choix du libelle
        }
        $retour .= "</select><br>";

        return $retour;
    }

    public function agencesAvecToutesCategories() : string {
        $stm4=$this->bdd->query("select code_ag from agence where not exists (select code_categ from categorie where code_categ not in (select code_categ from vehicule where code_ag = agence.code_ag));");

        $retour = "Les agences suivantes ont toutes les catégories de véhicules : </br>";
        while ($donnes = $stm4->fetch(PDO::FETCH_ASSOC)) {
            $retour .= $donnes['code_ag']."</br>";
        }
        return $retour;
    }

    public function clients2Modeles() : string {
        $stm5=$this->bdd->query("SELECT nom,ville,codpostal FROM client, dossier, vehicule WHERE client.code_cli = dossier.code_cli AND dossier.no_imm=vehicule.no_imm GROUP BY nom,ville,codpostal HAVING COUNT(DISTINCT modele)>=2");

        $retour = "Les clients suivants ont loués au moins deux véhicules différents : </br>";
        while ($donnes = $stm5->fetch(PDO::FETCH_ASSOC)) {
            $retour .= $donnes['nom']." habitant à ".$donnes['ville']." (".$donnes['codpostal'].")</br>";
        }
        return $retour;
    }
}





















