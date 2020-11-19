<?php

require("fpdf/fpdf.php");
include("class.pdogsb.inc.php");
// Création de la class PDF
class PDF extends FPDF {
    // Header
    function Header() {
      // Logo : 8 >position à gauche du document (en mm), 2 >position en haut du document, 80 >largeur de l'image en mm). La hauteur est calculée automatiquement.
      $this->Image('../images/logo.jpg',8,'C',1);
      // Saut de ligne 20 mm
      $this->Ln(20);

      // Titre gras (B) police Helbetica de 11
      $this->SetFont('Helvetica','B',11);
      // fond de couleur gris (valeurs en RGB)
      $this->SetTextColor(31,73,125)
       // position du coin supérieur gauche par rapport à la marge gauche (mm)
      $this->SetX(70);
      // Texte : 60 >largeur ligne, 8 >hauteur ligne. Premier 0 >pas de bordure, 1 >retour à la ligneensuite, C >centrer texte, 1> couleur de fond ok  
      $this->Cell(60,8,'REMBOURSEMENT DE FRAIS ENGAGES',0,1,'C');
      // Saut de ligne 10 mm     
      $this->Ln(10);
    }

    //Création du PDF pour les Fiches de Frais
    function createPDF($idVisiteur, $numMois, $numAnnee){
      // On active la classe une fois pour toutes les pages suivantes
      // Format portrait (>P) ou paysage (>L), en mm (ou en points > pts), A4 (ou A5, etc.)
      $pdf = new PDF('P','mm','A4');

      // Nouvelle page A4 (incluant ici logo, titre et pied de page)
      $pdf->AddPage();
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
      $id = $visiteur['id'];
			$nom =  $visiteur['nom'];
			$prenom = $visiteur['prenom'];
      // Texte : 60 >largeur ligne, 8 >hauteur ligne. Premier 0 >pas de bordure, 1 >retour à la ligneensuite, C >centrer texte, 1> couleur de fond ok  
      $pdf->Cell(60,8,$id,0,1,1);
      $pdf->SetX(90);
      // Texte : 60 >largeur ligne, 8 >hauteur ligne. Premier 0 >pas de bordure, 1 >retour à la ligneensuite, C >centrer texte, 1> couleur de fond ok  
      $pdf->Cell(60,8,"'.$prenom.' '.$nom.'",0,1);
       // Saut de ligne 10 mm
       $pdf->Ln(5);
        // Texte : 60 >largeur ligne, 8 >hauteur ligne. Premier 0 >pas de bordure, 1 >retour à la ligneensuite, C >centrer texte, 1> couleur de fond ok  
      $pdf->Cell(60,8,"Mois",0,1,1);
      $pdf->SetX(90);
      // Texte : 60 >largeur ligne, 8 >hauteur ligne. Premier 0 >pas de bordure, 1 >retour à la ligneensuite, C >centrer texte, 1> couleur de fond ok
      $EcritureMois;
      switch($numMois){
        case '01': {
          
        }
      }
      $pdf->Cell(60,8,"'.$prenom.' '.$numAnnee.'",0,1);

      $position_entete = 70;
      // police des caractères
      $pdf->SetFont('Helvetica','',9);
      $pdf->SetTextColor(31,73,125);
      // on affiche les en-têtes du tableau
      entete_table($position_entete);
      getLesFraisForfait($idVisiteur, $mois);
    }

    // Fonction en-tête des tableaux en 3 colonnes de largeurs variables
    function entete_table($position_entete) {
      global $pdf;
      $pdf->SetDrawColor(255,255,255); // Couleur du fond RVB
      $pdf->SetFillColor(221); // Couleur des filets RVB
      $pdf->SetTextColor(31,73,125); // Couleur du texte noir
      $pdf->SetY($position_entete);
      // position de colonne 1 (10mm à gauche)  
      $pdf->SetX(10);
      $pdf->Cell(60,8,'Frais Forfaitaires',1,0,'C',1);  // 60 >largeur colonne, 8 >hauteur colonne
      // position de la colonne 2 (70 = 10+60)
      $pdf->SetX(70); 
      $pdf->Cell(30,8,'Quantité',1,0,'C',1);
      // position de la colonne 3 (100 = 70+30)
      $pdf->SetX(100); 
      $pdf->Cell(30,8,'Montant unitaire',1,0,'C',1);
      // position de la colonne 3 (100 = 70+30)
      $pdf->SetX(100); 
      $pdf->Cell(30,8,'Total',1,0,'C',1);

      $pdf->Ln(); // Retour à la ligne
    }

    // Footer
    function Footer() {
      // Positionnement à 1,5 cm du bas
      $this->SetY(-15);
      // Police Arial italique 8
      $this->SetFont('Helvetica','I',9);
      // Numéro de page, centré (C)
      $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
  }

?>