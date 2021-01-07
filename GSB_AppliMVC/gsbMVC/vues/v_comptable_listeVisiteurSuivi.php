<div id="contenu">
      <h2>Sélectionner une Fiche de Frais</h2>
      <h3>Mois et personne à sélectionner : </h3>
      <form action="index.php?uc=suiviFrais&action=voirEtatFraisParIdVisiteur" method="post">
      <div class="corpsForm">
         
      <p>
	 
        <label for="lstMois" accesskey="n">Mois : </label>
        <select id="lstMois" name="lstMois">
            <?php
			foreach ($lesMois as $unMois)
			{
			    $mois = $unMois['mois'];
				$numAnnee =  $unMois['numAnnee'];
				$numMois =  $unMois['numMois'];
				if($mois == $moisASelectionner){
				?>
				<option selected value="<?php echo $mois ?>"><?php echo  $numMois."/".$numAnnee ?> </option>
				<?php 
				}
				else{ ?>
				<option value="<?php echo $mois ?>"><?php echo  $numMois."/".$numAnnee ?> </option>
				<?php 
        }
      }
		   ?>
            
        </select>
        <select id="personne" name="personne">
            <?php
			foreach ($allVisiteur as $visiteurs)
			{
			          $nom = $visiteurs['nom'];
                $prenom =  $visiteurs['prenom'];
                $id = $visiteurs['id'];
          if($id == $visiteurActuel['id']){
                ?>
          <option selected value="<?php echo $id?>"><?php echo  $nom." ".$prenom ?> </option>
          <?php }else{ ?>
				<option value="<?php echo $id?>"><?php echo  $nom." ".$prenom ?> </option>
				<?php
          }
      }
      var_dump($id);
		   ?>
        </select>
      </p>
      </div>
      <div class="piedForm">
      <p>
        <input id="ok" type="submit" value="Valider" size="20" />
        <input id="annuler" type="reset" value="Effacer" size="20" />
      </p> 
      </div>
        
      </form>