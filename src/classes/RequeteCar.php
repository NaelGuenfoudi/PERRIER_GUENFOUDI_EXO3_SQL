<?php

require_once 'src/classes/ConnectionFactory.php';

class RequeteCar {

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
    public function requete1($cat, $dateD, $dateF) : string {
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
        return $stm11;
    }


    public function requete2($no_imm, $dateD, $dateF) : string {
        $requeteCheckLibre = "select paslibre from calendrier where (datejour between str_to_date(?,'%Y-%m-%d') and str_to_date(?,'%Y-%m-%d')) and no_imm = ?";
        $stm2a= $this->bdd->prepare($requeteCheckLibre);
        $stm2a->bindParam(1, $dateD);
        $stm2a->bindParam(2, $dateF);
        $stm2a->bindParam(3, $no_imm);
        $stm2a->execute();

        $flagToutLibre = true;

        while ($donnees = $stm2a->fetch(PDO::FETCH_ASSOC)) {
            if ($donnees['paslibre']!=null) {
                $flagToutLibre = false;
            }
        }

        if ($flagToutLibre){
            $stm2b = $this->bdd->prepare("update calendrier set paslibre = 'x' where (datejour between str_to_date(?,'%Y-%m-%d') and str_to_date(?,'%Y-%m-%d')) and no_imm = ?");
            $stm2b->bindParam(1, $dateD);
            $stm2b->bindParam(2, $dateF);
            $stm2b->bindParam(3, $no_imm);
            $stm2b->execute();
            $retour = "la validation a bien été prise en compte";
        } else {
            $retour = "le véhicule n'est pas disponible sur la période demandée";
        }
        return $retour;
    }

    public function listerImmatriculations() {
        $stm21 = $this->bdd->query("select no_imm from vehicule");
        return $stm21;
    }


    public function requete3($modele, $nbJours) : string {
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
        return $stm31;
    }

    public function requete4() : string {
        $stm4=$this->bdd->query("select code_ag from agence where not exists (select code_categ from categorie where code_categ not in (select code_categ from vehicule where code_ag = agence.code_ag));");
        $retour = "Les agences suivantes ont toutes les catégories de véhicules : </br>";
        $retour .= "<ul>";
        while ($donnes = $stm4->fetch(PDO::FETCH_ASSOC)) {
            $retour .= "<li>".$donnes['code_ag']."</li></br>";
        }
        $retour .= "</ul>";
        return $retour;
    }

    public function requete5() : string {
        $stm5=$this->bdd->query("SELECT nom,ville,codpostal FROM client, dossier, vehicule WHERE client.code_cli = dossier.code_cli AND dossier.no_imm=vehicule.no_imm GROUP BY nom,ville,codpostal HAVING COUNT(DISTINCT modele)>=2");

        $retour = "Les clients suivants ont loués au moins deux véhicules différents : </br>";
        $retour .= "<ul>";
        while ($donnes = $stm5->fetch(PDO::FETCH_ASSOC)) {
            $retour .= "<li>".$donnes['nom']." habitant à ".$donnes['ville']." (".$donnes['codpostal'].")</li></br>";
        }
        $retour .= "</ul>";
        return $retour;
    }
}





















