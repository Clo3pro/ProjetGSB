<?php
require("./require/fpdf/fpdf.php");
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
	case 'createPDF':{
		$leMois = $_REQUEST['lstMois'];
		$lesMois=$pdo->getLesMoisDisponibles($idVisiteur);
		$moisASelectionner = $leMois;
		$numMois = $_REQUEST['numMois'];
		$numAnnee = $_REQUEST['numAnnee'];
		$pdf = new FPDF();
		$pdf->AddPage();
		// On active la classe une fois pour toutes les pages suivantes
		// Format portrait (>P) ou paysage (>L), en mm (ou en points > pts), A4 (ou A5, etc.
		// Nouvelle page A4 (incluant ici logo, titre et pied de page)
		// Polices par défaut : Helvetica taille 24
		$pdf->SetFont('Helvetica','',24);
		$pdf->SetTextColor(31,73,125);
		// Compteur de pages {nb}
		$pdf->AliasNbPages();
		$pdf->SetX(70);
		// Texte : 60 >largeur ligne, 8 >hauteur ligne. Premier 0 >pas de bordure, 1 >retour à la ligneensuite, C >centrer texte, 1> couleur de fond ok  
		$pdf->Cell(60,8,'REMBOURSEMENT DE FRAIS ENGAGES',0,1,'C');
		// Saut de ligne 10 mm
		$pdf->Ln(10);
		$pdf->SetX(10);
		// Texte : 60 >largeur ligne, 8 >hauteur ligne. Premier 0 >pas de bordure, 1 >retour à la ligneensuite, C >centrer texte, 1> couleur de fond ok  
		$pdf->Cell(60,8,'Visiteur',0,1,'C',1);
		$pdf->SetX(40);
		$visiteur = $pdo->getInfosVisiteurById($idVisiteur);
		$nom =  $visiteur['nom'];
		$prenom = $visiteur['prenom'];
		// Texte : 60 >largeur ligne, 8 >hauteur ligne. Premier 0 >pas de bordure, 1 >retour à la ligneensuite, C >centrer texte, 1> couleur de fond ok  
		$pdf->Cell(60,8,$idVisiteur,0,1,1);
		$pdf->SetX(90);
		// Texte : 60 >largeur ligne, 8 >hauteur ligne. Premier 0 >pas de bordure, 1 >retour à la ligneensuite, C >centrer texte, 1> couleur de fond ok  
		$pdf->Cell(90,8,"'.$prenom .' '.$nom",0,1);
		// Saut de ligne 10 mm
		$pdf->Ln(5);
		// Texte : 60 >largeur ligne, 8 >hauteur ligne. Premier 0 >pas de bordure, 1 >retour à la ligneensuite, C >centrer texte, 1> couleur de fond ok  
		$pdf->Cell(60,8,"Mois",0,1,1);
		$pdf->SetX(90);
		// Texte : 60 >largeur ligne, 8 >hauteur ligne. Premier 0 >pas de bordure, 1 >retour à la ligneensuite, C >centrer texte, 1> couleur de fond ok
		$EcritureMois = "actuel";
		switch($numMois){
		case '01': {
			$EcritureMois = "Janvier";
		break;
		}
		case '02': {
			$EcritureMois = "Février";
		break;
		}
		case '03': {
			$EcritureMois = "Mars";
		break;
		}
		case '04': {
			$EcritureMois = "Avril";
		break;
		}
		case '05': {
			$EcritureMois = "Mai";
		break;
		}
		case '06': {
			$EcritureMois = "Juin";
		break;
		}
		case '07': {
			$EcritureMois = "Juillet";
		break;
		}
		case '08': {
			$EcritureMois = "Août";
		break;
		}
		case '09': {
			$EcritureMois = "Septembre";
		break;
		}
		case '10': {
			$EcritureMois = "Octobre";
		break;
		}
		case '11': {
			$EcritureMois = "Novembre";
		break;
		}
		case '12': {
			$EcritureMois = "Décembre";
		break;
		}
    }
		$pdf->Cell(60,8,"'.$EcritureMois.' '.$numAnnee.'",0,1);
		$pdf->Ln(10);

		$position_entete = 70;
		$position_detail = 78;
		// police des caractères
		$pdf->SetFont('Helvetica','',9);
		$pdf->SetTextColor(31,73,125);
		// on affiche les en-têtes du tableau
		//entete_table($position_entete);
		$lesFraisForfait= $pdo->getLesFraisForfait($idVisiteur,$leMois);
		foreach ($lesFraisForfait as $unFrais){
		// position abcisse de la colonne 1 (10mm du bord)
		$pdf->SetY($position_detail);
		$pdf->SetX(10);
		$pdf->MultiCell(60,8,$unFrais['libelle'],1,'C');
			// position abcisse de la colonne 2 (70 = 10 + 60)
		$pdf->SetY($position_detail);
		$pdf->SetX(70); 
		$pdf->MultiCell(60,8,$unFrais['quantite'],1,'C');
		// position abcisse de la colonne 3 (130 = 70+ 60)
		$pdf->SetY($position_detail);
		$pdf->SetX(130); 
		$pdf->MultiCell(30,8,$unFrais['montantUnitaire'],1,'C');
		// on incrémente la position ordonnée de la ligne suivante (+8mm = hauteur des cellules)
		$position_detail += 8;
		}
		ob_end_clean();
		$pdf->Output('test.pdf', 'I');
	break;
	}
}
?>