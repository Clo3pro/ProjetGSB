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
		include("vues/v_listeVisiteurMois.php");
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
		if( $_GET['etat'] == 'CL'){
			$etat = 'VA';
			$pdo->majEtatFicheFrais($IdVisiteurSelectionne,$leMois,$etat);
		}elseif($_GET['etat'] == 'VA'){
			$etat = 'RB';
			$pdo->majEtatFicheFrais($IdVisiteurSelectionne,$leMois,$etat);
		}
		$dateModif =  dateAnglaisVersFrancais($dateModif);
		include("vues/v_comptable_suiviFrais.php");
		break;
	}
	case 'createPDF':{
		include("vues/v_entete.php");
		$numMois = $_REQUEST['numMois'];
		$numAnnee = $_REQUEST['numAnnee'];
		$montantGlobal = $_REQUEST['montantGlobal'];
		$mois = $numAnnee."".$numMois;
		$pdf = new tFPDF();
		$pdf->AddPage();
		$pdf->SetFont('Helvetica','B',11); 
		// fond de couleur gris (valeurs en RGB)
	   	$pdf->SetTextColor(31,73,125);
		// Logo : 8 >position à gauche du document (en mm), 2 >position en haut du document, 80 >largeur de l'image en mm). La hauteur est calculée automatiquement.
		$pdf->Image('./images/logo.jpg',8,2);
		// Titre gras (B) police Helbetica de 11
		$pdf->SetFont('Helvetica','B',16); 
		// fond de couleur gris (valeurs en RGB)
		$pdf->SetTextColor(31,73,125);
		// position du coin supérieur gauche par rapport à la marge gauche (mm)
		$pdf->SetX(90);
		// Texte : 60 >largeur ligne, 8 >hauteur ligne. Premier 0 >pas de bordure, 1 >retour à la ligneensuite, C >centrer texte, 1> couleur de fond ok  
		$pdf->Cell(60,8,'REMBOURSEMENT DE FRAIS ENGAGES',0,1,'C');
		// Saut de ligne 10 mm     
		$pdf->Ln(30);
		$pdf->SetX(10);
		// Texte : 60 >largeur ligne, 8 >hauteur ligne. Premier 0 >pas de bordure, 1 >retour à la ligneensuite, C >centrer texte, 1> couleur de fond ok  
		$pdf->Cell(90,0,'Visiteur numéro : '.$idVisiteur,0,1);
		$pdf->SetX(40);
		$pdf->Ln(10);
		$visiteur = $pdo->getInfosVisiteurById($idVisiteur);
		// Texte : 60 >largeur ligne, 8 >hauteur ligne. Premier 0 >pas de bordure, 1 >retour à la ligneensuite, C >centrer texte, 1> couleur de fond ok  
		$pdf->Cell(60,0,'Nom et Prénom : '.$visiteur["prenom"].' - '.$visiteur["nom"],0,1);
		// Saut de ligne 10 mm
		$pdf->Ln(10);
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
		$pdf->Cell(60,0,'Pour '.$EcritureMois.' '.$numAnnee,0,1);
		$position_entete = 78;
		$position_detail = 86;
		// police des caractères
		$pdf->SetFont('Helvetica','',9);
		$pdf->SetTextColor(31,73,125);
		// on affiche les en-têtes du tableau
		$pdf->SetDrawColor(183); // Couleur du fond RVB
		$pdf->SetFillColor(221); // Couleur des filets RVB
		$pdf->SetTextColor(0); // Couleur du texte noir
		$pdf->SetY($position_entete);
		// position de colonne 1 (10mm à gauche)  
		$pdf->SetX(15);
		$pdf->Cell(60,8,'Nom',1,0,'C',1);  // 60 >largeur colonne, 8 >hauteur colonne
		// position de la colonne 2 (70 = 10+60)
		$pdf->SetX(75); 
		$pdf->Cell(60,8,'Quantité',1,0,'C',1);
		// position de la colonne 3 (130 = 70+60)
		$pdf->SetX(135); 
		$pdf->Cell(30,8,'Montant Unitaire',1,0,'C',1);
		$pdf->SetX(165); 
		$pdf->Cell(30,8,'Total',1,0,'C',1);
		$lesFraisForfait= $pdo->getLesFraisForfait($idVisiteur,$mois);
		$montantTotalFicheFrais = 0;
		foreach ($lesFraisForfait as $unFrais){
		// position abcisse de la colonne 1 (10mm du bord)
		$pdf->SetY($position_detail);
		$pdf->SetX(15);
		$pdf->MultiCell(60,8,$unFrais['libelle'],1,'C');
			// position abcisse de la colonne 2 (75 = 15 + 60)
		$pdf->SetY($position_detail);
		$pdf->SetX(75); 
		$pdf->MultiCell(60,8,$unFrais['quantite'],1,'C');
		// position abcisse de la colonne 3 (135 = 75+ 30)
		$pdf->SetY($position_detail);
		$pdf->SetX(135); 
		$pdf->MultiCell(30,8,$unFrais['montantUnitaire'],1,'C');
		// on incrémente la position ordonnée de la ligne suivante (+8mm = hauteur des cellules)
		// position abcisse de la colonne 3 (130 = 70+ 60)
		$pdf->SetY($position_detail);
		$pdf->SetX(165);
		$total = $unFrais['montantUnitaire']*$unFrais['quantite'];
		$pdf->MultiCell(30,8,$total,1,'C');
		// on incrémente la position ordonnée de la ligne suivante (+8mm = hauteur des cellules)
		$position_detail += 8;
		$montantTotalFicheFrais +=$total; 
		}
		$pdf->SetY($position_detail);
		$pdf->SetX(165);
		$pdf->MultiCell(30,8,$montantTotalFicheFrais." euros",1,'C');

		$position_entete = 130;
		$position_detail = 138;
		// police des caractères
		$pdf->SetFont('Helvetica','',9);
		$pdf->SetTextColor(31,73,125);
		// on affiche les en-têtes du tableau
		$pdf->SetDrawColor(183); // Couleur du fond RVB
		$pdf->SetFillColor(221); // Couleur des filets RVB
		$pdf->SetTextColor(0); // Couleur du texte noir
		$pdf->SetY($position_entete);
		// position de colonne 1 (10mm à gauche)  
		$pdf->SetX(15);
		$pdf->Cell(60,8,'Date',1,0,'C',1);  // 60 >largeur colonne, 8 >hauteur colonne
		// position de la colonne 2 (70 = 10+60)
		$pdf->SetX(75); 
		$pdf->Cell(60,8,'Libellé',1,0,'C',1);
		// position de la colonne 3 (130 = 70+60)
		$pdf->SetX(135); 
		$pdf->Cell(30,8,'Montant',1,0,'C',1);
		$pdf->SetX(165); 
		$pdf->Cell(30,8,'Total',1,0,'C',1);
		$totalMontantHorsForfait = 0;
		$lesFraisHorsForfait=$pdo->getLesFraisHorsForfait($idVisiteur,$mois);
		foreach($lesFraisHorsForfait as $unFraisHorsForfait){
		// position abcisse de la colonne 1 (10mm du bord)
		$pdf->SetY($position_detail);
		$pdf->SetX(15);
		$pdf->MultiCell(60,8, $unFraisHorsForfait['date'],1,'C');
			// position abcisse de la colonne 2 (75 = 15 + 60)
		$pdf->SetY($position_detail);
		$pdf->SetX(75); 
		$pdf->MultiCell(60,8,$unFraisHorsForfait['libelle'],1,'C');
		// position abcisse de la colonne 3 (135 = 75+ 30)
		$pdf->SetY($position_detail);
		$pdf->SetX(135); 
		$pdf->MultiCell(30,8,$unFraisHorsForfait['montant'],1,'C');
		$pdf->SetY($position_detail);
		$pdf->SetX(165); 
		$pdf->MultiCell(30,8,"",1,'C');
		// on incrémente la position ordonnée de la ligne suivante (+8mm = hauteur des cellules)
		$position_detail += 8;
		$totalMontantHorsForfait += $unFraisHorsForfait['montant'];
		}
		$pdf->SetY($position_detail);
		$pdf->SetX(165);
		$pdf->MultiCell(30,8,$totalMontantHorsForfait." euros",1,'C');
		$pdf->Ln(10);
		$pdf->SetX(135);
	   	$pdf->SetTextColor(31,73,125);
		$pdf->SetFont('Helvetica','B',16); 
		$pdf->Cell(60,0,'Total de '.$montantGlobal.' euros',0,1);
		// Saut de ligne 10 mm
		
		ob_end_clean();
		$pdf->Output('Fiche de frais.pdf', 'D', true);
		
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