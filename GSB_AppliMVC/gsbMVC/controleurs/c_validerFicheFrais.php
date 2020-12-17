<?php
include("vues/v_sommaire.php");
$idVisiteur = $_SESSION['idVisiteur'];
$mois = getMois(date("d/m/Y"));
$numAnnee =substr( $mois,0,4);
$numMois =substr( $mois,4,2);
$action = $_REQUEST['action'];

switch($action){
    case 'selectionnerMoisPersonne': {
		$lesMois=$pdo->getMois();
		// Afin de sélectionner par défaut le dernier mois dans la zone de liste
		// on demande toutes les clés, et on prend la première,
		// les mois étant triés décroissants
		$lesCles = array_keys( $lesMois );
		$moisASelectionner = $lesCles[0];
		$allVisiteur=$pdo->getAllVisiteurs();
        include("vues/v_listeVisiteurMois.php");
	break;
    }
    case 'voirEtatFraisParIdVisiteur' : {
		$leMois = $_REQUEST['lstMois'];
		$IdVisiteurSelectionne = $_REQUEST['personne'];
		$lesMois=$pdo->getMois();
		$allVisiteur=$pdo->getAllVisiteurs();
		$visiteurActuel=$pdo->getInfosVisiteurById($IdVisiteurSelectionne);
		$moisASelectionner = $leMois;
		include("vues/v_listeVisiteurMois.php");
		$lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($IdVisiteurSelectionne,$leMois);
		$lesFraisForfait= $pdo->getLesFraisForfait($IdVisiteurSelectionne,$leMois);
		$lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($IdVisiteurSelectionne,$leMois);
		$numAnnee =substr( $leMois,0,4);
		$numMois =substr( $leMois,4,2);
		$libEtat = $lesInfosFicheFrais['libEtat'];
		$montantValide = $lesInfosFicheFrais['montantValide'];
		$nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
		$dateModif =  $lesInfosFicheFrais['dateModif'];
		$dateModif =  dateAnglaisVersFrancais($dateModif);
		include("vues/v_etatFraisParComptable.php");
		break;
    }
    case 'ValiderFicheFrais' : {
        if($_REQUEST['supp'] == 1 && !empty($_REQUEST["FraisHorsForfait"])){
            $idFraisASupp = $_REQUEST["FraisHorsForfait"];
            if($idFraisASupp != ""){
                for($i = 0; $i < count($idFraisASupp); $i++){
                    $pdo->supprimerFraisHorsForfait($idFraisASupp[$i]);
                }
            }
        }
        $idVisiteurAModif = $_REQUEST['idVisiteur'];
        $montantGlobal = $_REQUEST['montantGlobalTotal'];
        var_dump($_REQUEST['montantGlobalTotal']);
        $pdo->majEtatFicheFrais($idVisiteurAModif, $mois, "CL");
        $pdo->validerFicheFrais($idVisiteurAModif, $mois, $montantGlobal);
    }
}
?>



