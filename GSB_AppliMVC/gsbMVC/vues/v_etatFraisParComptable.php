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
    <form method="POST" action="index.php?uc=validerFicheFrais&action=ValiderFicheFrais&idVisiteur=<?= ($visiteurActuel['id']) ?>&supp=1">
  	<table class="listeLegere">
  	   <caption>Descriptif des éléments hors forfait -<?php echo $nbJustificatifs ?> justificatifs reçus -
       </caption>
             <tr>
                <th class="date">Date</th>
                <th class="libelle">Libellé</th>
                <th class='montant'>Montant</th>
                <th class='montant'>Action</th>
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
                <td><span id="supp" style="color:red;"></span><?php echo $libelle ?></td>
                <td><?php echo $montant ?></td>
                <td>
                  <select name="FraisHorsForfait[]" id="changeComptableFraisHors">
                    <option value=""></option>
                    <option value="<?php echo $id; ?>">Refuser</option>
                  </select>
                  <input style="display:none" id="montant" value="<?php echo $montant; ?>">
                </td>
             </tr>
        <?php 
          }
        
		?>
    
    </table>
    <table class="listeLegere" style="margin-right:30px; margin-top:20px" align="right">
    <tr>
    <th>Montant Total du mois</th></tr>
      <tr><td><span id="montantGlobal"></span></td></tr>
    </table>
    <input class="buttonValider" type="submit" value="Valider"/>
  </div>
  
  </div>
          <input style="display:none;" id="montantGlobalTotal" name="montantGlobalTotal" value="<?php echo $montantGlobalTotal; ?>"/>
        </form>
<?php } ?>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script>
   var montantGlobal = "<?php echo $montantGlobalTotal; ?>";
      $("#montantGlobal").html(montantGlobal);
      var montantGlob = Number($("#montantGlobalTotal").val());
      $("#vraiMontantGlobal").html(montantGlob);

$("#changeComptableFraisHors").change(function() {
  var selected = $("#changeComptableFraisHors").val();
  var montantGlob = Number($("#montantGlobalTotal").val());


    if(selected != ""){
      $("#supp").html("<B>REFUSE</B> ");

      var montant = Number($("#montant").val());
      montantGlob = montantGlob - montant;
      $("#montantGlobalTotal").attr("value", montantGlob);
      $("#montantGlobal").html(montantGlob); 
     

    }else{
      $("#supp").html("");
      var montant = Number($("#montant").val());
      montantGlob = montantGlob + montant;
      $("#montantGlobalTotal").attr("value", montantGlob);
      $("#montantGlobal").html(montantGlob); 

    }
});
</script>