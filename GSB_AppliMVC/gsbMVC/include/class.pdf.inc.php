<?php
// include("vues/v_sommaire.php");
// require("./require/fpdf/fpdf.php");
// $pdf = new FPDF();
// $pdf->AddPage();
// $pdf->SetFont('Arial','B',16);
// $pdf->Cell(40,10,'Hello World!');
// $pdf->Output('test.pdf', 'I');
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

//   function createPDF($idVisiteur, $numMois, $numAnnee, $mois){
//     require("./require/fpdf/fpdf.php");
//     // require("include/class.pdogsb.inc.php");
//     // $pdo2 = PdoGsb::getPdoGsb();
//     // // On active la classe une fois pour toutes les pages suivantes
//     // // Format portrait (>P) ou paysage (>L), en mm (ou en points > pts), A4 (ou A5, etc.)
//     // $pdf = new FPDF();

//     // // Nouvelle page A4 (incluant ici logo, titre et pied de page)
//     // $pdf->AddPage();
//     // // Polices par défaut : Helvetica taille 24
//     // $pdf->SetFont('Helvetica','',24);

//     // $pdf->SetTextColor(31,73,125);
//     // // Compteur de pages {nb}
//     // $pdf->AliasNbPages();

//     // $pdf->SetX(70);
//     // // Texte : 60 >largeur ligne, 8 >hauteur ligne. Premier 0 >pas de bordure, 1 >retour à la ligneensuite, C >centrer texte, 1> couleur de fond ok  
//     // $pdf->Cell(60,8,'REMBOURSEMENT DE FRAIS ENGAGES',0,1,'C');
//     // // Saut de ligne 10 mm
//     // $pdf->Ln(10);

//     // $pdf->SetX(10);
//     // // Texte : 60 >largeur ligne, 8 >hauteur ligne. Premier 0 >pas de bordure, 1 >retour à la ligneensuite, C >centrer texte, 1> couleur de fond ok  
//     // $pdf->Cell(60,8,'Visiteur',0,1,'C',1);
//     // $pdf->SetX(40);
//     // $visiteur = $pdo2->getInfosVisiteurById($idVisiteur);
//     // $id = $visiteur['id'];
//     // $nom =  $visiteur['nom'];
//     // $prenom = $visiteur['prenom'];
//     // // Texte : 60 >largeur ligne, 8 >hauteur ligne. Premier 0 >pas de bordure, 1 >retour à la ligneensuite, C >centrer texte, 1> couleur de fond ok  
//     // $pdf->Cell(60,8,$id,0,1,1);
//     // $pdf->SetX(90);
//     // // Texte : 60 >largeur ligne, 8 >hauteur ligne. Premier 0 >pas de bordure, 1 >retour à la ligneensuite, C >centrer texte, 1> couleur de fond ok  
//     // $pdf->Cell(90,8,"'.$prenom .' '.$nom",0,1);
//     //  // Saut de ligne 10 mm
//     //  $pdf->Ln(5);
//     //   // Texte : 60 >largeur ligne, 8 >hauteur ligne. Premier 0 >pas de bordure, 1 >retour à la ligneensuite, C >centrer texte, 1> couleur de fond ok  
//     // $pdf->Cell(60,8,"Mois",0,1,1);
//     // $pdf->SetX(90);
//     // // Texte : 60 >largeur ligne, 8 >hauteur ligne. Premier 0 >pas de bordure, 1 >retour à la ligneensuite, C >centrer texte, 1> couleur de fond ok
//     // $EcritureMois = "actuel";
//     // switch($numMois){
//     //   case '01': {
//     //     $EcritureMois = "Janvier";
//     //     break;
//     //   }
//     //   case '02': {
//     //     $EcritureMois = "Février";
//     //     break;
//     //   }
//     //   case '03': {
//     //     $EcritureMois = "Mars";
//     //     break;
//     //   }
//     //   case '04': {
//     //     $EcritureMois = "Avril";
//     //     break;
//     //   }
//     //   case '05': {
//     //     $EcritureMois = "Mai";
//     //     break;
//     //   }
//     //   case '06': {
//     //     $EcritureMois = "Juin";
//     //     break;
//     //   }
//     //   case '07': {
//     //     $EcritureMois = "Juillet";
//     //     break;
//     //   }
//     //   case '08': {
//     //     $EcritureMois = "Août";
//     //     break;
//     //   }
//     //   case '09': {
//     //     $EcritureMois = "Septembre";
//     //     break;
//     //   }
//     //   case '10': {
//     //     $EcritureMois = "Octobre";
//     //     break;
//     //   }
//     //   case '11': {
//     //     $EcritureMois = "Novembre";
//     //     break;
//     //   }
//     //   case '12': {
//     //     $EcritureMois = "Décembre";
//     //     break;
//     //   }

//     // }
//     // $pdf->Cell(60,8,"'.$EcritureMois.' '.$numAnnee.'",0,1);
//     // $pdf->Ln(10);

//     // $position_entete = 70;
//     // $position_detail = 78;
//     // // police des caractères
//     // $pdf->SetFont('Helvetica','',9);
//     // $pdf->SetTextColor(31,73,125);
//     // // on affiche les en-têtes du tableau
//     // //entete_table($position_entete);
//     // $lesFraisForfait= $pdo2->getLesFraisForfait($idVisiteur,$mois);
//     //   foreach ($lesFraisForfait as $unFrais){
//     //   // position abcisse de la colonne 1 (10mm du bord)
//     //   $pdf->SetY($position_detail);
//     //   $pdf->SetX(10);
//     //   $pdf->MultiCell(60,8,$unFrais['libelle'],1,'C');
//     //     // position abcisse de la colonne 2 (70 = 10 + 60)  
//     //   $pdf->SetY($position_detail);
//     //   $pdf->SetX(70); 
//     //   $pdf->MultiCell(60,8,$unFrais['quantite'],1,'C');
//     //   // position abcisse de la colonne 3 (130 = 70+ 60)
//     //   $pdf->SetY($position_detail);
//     //   $pdf->SetX(130); 
//     //   $pdf->MultiCell(30,8,$unFrais['montantUnitaire'],1,'C');
    
//     //   // on incrémente la position ordonnée de la ligne suivante (+8mm = hauteur des cellules)  
//     //   $position_detail += 8; 
//     // }
//     // $pdf->Output('Fiche de frais.pdf','I');
    
// }
?>