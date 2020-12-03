
<h3>Fiche de frais du mois <?php echo $numMois."-".$numAnnee?> :
    </h3>
    <div class="encadre">
    
    <p>
        Etat : <?php echo $libEtat?> depuis le <?php echo $dateModif?> <br> Montant validé : <?php echo $montantValide?>
              
                     
    </p>
    <form method="POST" action="index.php?uc=etatFrais&action=createPDF">
      <input type="text" style="display:none" name="numMois" value="<?php echo $numMois;?>">
      <input type="text" style="display:none" name="numAnnee" value="<?php echo $numAnnee;?>">
      <input type="text" style="display:none" name="mois" value="<?php echo $mois;?>">
      <input type="submit" value="DownLoad PDF" />
    </form>
  	<table class="listeLegere">
  	   <caption>Eléments forfaitisés </caption>
        <tr>
            
            <th>Frais Forfaitaires</th>
            <th>Quantité</th>
            <th>Montant Unitaire</th>
            <th>Total</th>

        </tr>
        
         <?php
         $montantGlobalTotal = 0;
         foreach ( $lesFraisForfait as $unFraisForfait ) 
		 {
          $libelle = $unFraisForfait['libelle'];
          $quantite = $unFraisForfait['quantite'];
          $montantUni = $unFraisForfait['montantUnitaire'];
          $montantTotal = $quantite * $montantUni;
          $montantGlobalTotal += $montantTotal;
		?>	
      <tr>
			  <td> <?php echo $libelle?></td>
        <td> <?php echo $quantite?></td>
        <td> <?php echo $montantUni?></td>
        <td> <?php echo $montantTotal?></td>
      </tr>
		 <?php
        }
		?>
		
    </table>
  	<table class="listeLegere">
  	   <caption>Descriptif des éléments hors forfait -<?php echo $nbJustificatifs ?> justificatifs reçus -
       </caption>
             <tr>
                <th class="date">Date</th>
                <th class="libelle">Libellé</th>
                <th class='montant'>Montant</th>                
             </tr>
        <?php      
          foreach ( $lesFraisHorsForfait as $unFraisHorsForfait ) 
		  {
			$date = $unFraisHorsForfait['date'];
			$libelle = $unFraisHorsForfait['libelle'];
      $montant = $unFraisHorsForfait['montant'];
      $montantGlobalTotal += $montant;
		?>
             <tr>
                <td><?php echo $date ?></td>
                <td><?php echo $libelle ?></td>
                <td><?php echo $montant ?></td>
             </tr>
        <?php 
          }
        
		?>
    
    </table>
    <table>
    <tr>
    <th>Montant Total du mois</th></tr>
      <tr><td><?php $montantGlobalTotal?></td></tr>
    </table>
  </div>
  </div>
 













