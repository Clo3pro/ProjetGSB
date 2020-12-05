<?php if(isset($_GET['idFraisHorsForfait'])){
    require_once ("include/class.pdogsb.inc.php");
    $idFrais = $_GET['idFraisHorsForfait'];
    var_dump($idFrais);
    supprimerFraisHorsForfait();
}
?>

<h3>Fiche de frais du mois <?php echo $numMois."-".$numAnnee. " de ". $visiteurActuel['nom']." ".$visiteurActuel['prenom']?> :

<?php if(count($lesFraisForfait) == 0){
        echo "<h3 style='color: red;'>Pas de fiche de frais disponible pour l'instant</h3>";
    }else {
    ?>
    </h3>
    <div class="encadre perso">
    <p>
        Etat : <?php echo $libEtat?> depuis le <?php echo $dateModif?> <br> Montant validé : <?php echo $montantValide?>
              
                     
    </p>
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
    <form action="#" type="">
  	<table class="listeLegere">
  	   <caption>Descriptif des éléments hors forfait -<?php echo $nbJustificatifs ?> justificatifs reçus -
       </caption>
             <tr>
                <th class="date">Date</th>
                <th class="libelle">Libellé</th>
                <th class='montant'>Montant<echo th>
             </tr>
        <?php
          foreach ( $lesFraisHorsForfait as $unFraisHorsForfait ) 
		  {
			$date = $unFraisHorsForfait['date'];
			$libelle = $unFraisHorsForfait['libelle'];
            $montant = $unFraisHorsForfait['montant'];
            $id = $unFraisHorsForfait['id'];
            $montantGlobalTotal += $montant;
		?>
             <tr>
                <td><?php echo $date ?></td>
                <td><?php echo $libelle ?></td>
                <td><?php echo $montant ?></td>
                <td><?php echo '<a href="index.php?uc=gererFrais&action=supprimerFrais&idFrais='.$id.'" 
				onclick="return confirm("Voulez-vous vraiment supprimer ce frais ?");">X</a>'; ?></td>
             </tr>
        <?php 
          }
        
		?>
    
    </table>
    <table class="listeLegere" style="margin-right:30px; margin-top:20px" align="right">
    <tr>
    <th>Montant Total du mois</th></tr>
      <tr><td><?php echo $montantGlobalTotal." euros";?></td></tr>
    </table>
  </div>
  </div>
          <input style="display:none;" name="montantGlobal" value="<?php  echo $montantGlobalTotal; ?>"/>
<?php } ?>