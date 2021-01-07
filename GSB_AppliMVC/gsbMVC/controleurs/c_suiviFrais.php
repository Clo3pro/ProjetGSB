<?php
include("vues/v_sommaire.php");
$action = $_REQUEST['action'];
$idVisiteur = $_SESSION['idVisiteur'];
switch($action){
	case 'selectionnerMois':{
		$lesMois=$pdo->getLesMoisDisponibles($idVisiteur);
		// Afin de sélectionner par défaut le dernier mois dans la zone de liste
		// on demande toutes les clés, et on prend la première,
		// les mois étant triés décroissants
		$lesCles = array_keys( $lesMois );
		$moisASelectionner = $lesCles[0];
		include("vues/v_listeMois.php");
		break;
	}
	case 'voirEtatFrais':{
		$leMois = $_REQUEST['lstMois'];
		$lesMois=$pdo->getLesMoisDisponibles($idVisiteur);
		$moisASelectionner = $leMois;
		include("vues/v_listeMois.php");
		$lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur,$leMois);
		$lesFraisForfait= $pdo->getLesFraisForfait($idVisiteur,$leMois);
		$lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idVisiteur,$leMois);
		$numAnnee =substr( $leMois,0,4);
		$numMois =substr( $leMois,4,2);
		$libEtat = $lesInfosFicheFrais['libEtat'];
		$montantValide = $lesInfosFicheFrais['montantValide'];
		$nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
		$dateModif =  $lesInfosFicheFrais['dateModif'];
		$dateModif =  dateAnglaisVersFrancais($dateModif);
		include("vues/v_etatFrais.php");
	break;
	}
	case 'voirEtatFraisParIdVisiteur' : {
		$leMois = $_REQUEST['lstMois'];
		$IdVisiteurSelectionne = $_REQUEST['personne'];
		$lesMois=$pdo->getMois();
		$allVisiteur=$pdo->getAllVisiteurs();
		$visiteurActuel=$pdo->getInfosVisiteurById($IdVisiteurSelectionne);
		$moisASelectionner = $leMois;
		include("vues/v_comptable_listeVisiteurSuivi.php");
		$lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($IdVisiteurSelectionne,$leMois);
		$lesFraisForfait= $pdo->getLesFraisForfait($IdVisiteurSelectionne,$leMois);
		$lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($IdVisiteurSelectionne,$leMois);
		$numAnnee =substr( $leMois,0,4);
		$numMois =substr( $leMois,4,2);
		$etat = $lesInfosFicheFrais['idEtat'];
		$libEtat = $lesInfosFicheFrais['libEtat'];
		$montantValide = $lesInfosFicheFrais['montantValide'];
		$nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
		$dateModif =  $lesInfosFicheFrais['dateModif'];
		$dateModif =  dateAnglaisVersFrancais($dateModif);
		include("vues/v_comptable_suiviFrais.php");
		break;
	}
	case 'majEtatFrais' : {
		$leMois = $_REQUEST['lstMois'];
		$IdVisiteurSelectionne = $_REQUEST['personne'];
		$lesMois=$pdo->getMois();
		$allVisiteur=$pdo->getAllVisiteurs();
		$visiteurActuel=$pdo->getInfosVisiteurById($IdVisiteurSelectionne);
		$lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($IdVisiteurSelectionne,$leMois);
		$lesFraisForfait= $pdo->getLesFraisForfait($IdVisiteurSelectionne,$leMois);
		$lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($IdVisiteurSelectionne,$leMois);
		$numAnnee =substr( $leMois,0,4);
		$numMois =substr( $leMois,4,2);
		$libEtat = $lesInfosFicheFrais['libEtat'];
		$montantValide = $lesInfosFicheFrais['montantValide'];
		$nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
		$dateModif =  $lesInfosFicheFrais['dateModif'];
		if( $_GET['etat'] == 'CL'){
			$etat = 'VA';
			$pdo->majEtatFicheFrais($IdVisiteurSelectionne,$leMois,$etat);
		}elseif($_GET['etat'] == 'VA'){
			$etat = 'RB';
			$pdo->majEtatFicheFrais($IdVisiteurSelectionne,$leMois,$etat);
		}
		$dateModif =  dateAnglaisVersFrancais($dateModif);
		include("vues/v_comptable_listeVisiteurSuivi.php");
		break;
	}
	case 'selectionnerMoisPersonne': {
		$lesMois=$pdo->getMois();
		// Afin de sélectionner par défaut le dernier mois dans la zone de liste
		// on demande toutes les clés, et on prend la première,
		// les mois étant triés décroissants
		$lesCles = array_keys( $lesMois );
		$moisASelectionner = $lesCles[0];
		$allVisiteur=$pdo->getAllVisiteurs();
		include("vues/v_comptable_listeVisiteurSuivi.php");
	break;
	}
}
?>