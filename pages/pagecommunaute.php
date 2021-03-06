<?php
$communaute= savoircommu($_GET["page"]);
$donnecommunaute=recupdonnecommu($communaute);
$idcommu = $donnecommunaute[0]['idcommu'];
$createur = recupdonneauteurcommu($idcommu);
$description = $donnecommunaute[0]['description'];
$idcreateur=$createur[0]['idcreateur'];

$membrecommu = selectusercommu($idcommu, $idcreateur);
$donnepost = recuppost($idcommu);
$_SESSION['donnepost'] = $donnepost;
$moderationcommu = recupmodocommu($idcommu);
$utilisateurbanni=recupbannicommu($idcommu);
$messagesdelacommu = recupmessagecommu($idcommu);

if (estdanscommu($_SESSION['id'], $idcommu) || $_SESSION['id']==$idcreateur) {
?>
<script src="js/script.js"></script>
<input type="hidden" id="iddemacommu" name="iddemacommu" value="<?php echo $idcommu; ?>" />

<div class="contener col-l-6 m-5 communaute p-4 ">
	
	<ul class="nav nav-pills nav-fill bg-white justify-content-center" id="myTab" role="tablist">
		<li class="nav-item">
			<a class="nav-link active btn" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Home</a>
		</li>
		<li class="nav-item">
			<a class="nav-link btn" id="tchat-tab" data-toggle="tab" href="#tchat" role="tab" aria-controls="tchat" aria-selected="false">Tchat</a>
		</li>
		<li class="nav-item">
			<a class="nav-link btn" id="stats-tab" data-toggle="tab" href="#stats" role="tab" aria-controls="stats" aria-selected="false">Stats</a>
		</li>
		<li class="nav-item">
			<a class="nav-link btn" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">
				Abonnés <span class="badge badge-danger text-dark"><?php echo sizeof($membrecommu) ?></span></a>


		</li>

	<?php if (estmodo($_SESSION['id'], $idcommu)) { ?>

		<li class="nav-item">
			<a class="nav-link" id="signal-tab" data-toggle="tab" href="#signaler" role="tab" aria-controls="signaler" aria-selected="false">Signalement</a>
		</li>

	<?php } ?>

	<?php if ($_SESSION['id']==$createur[0]['id']) { ?>

		<li class="nav-item bg-light ">
			<a class="nav-link btn-danger" id="admin-tab" data-toggle="tab" href="#admin" role="tab" aria-controls="admin" aria-selected="false">Admin</a>
		</li>

		
	<?php } ?>

	</ul>
	<div class="container col-lg-8 ">
		<div class="tab-content" id="myTabContent">
			<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
				<div class="container mt-4">
					<?php
						// Affichage d'une image de la communauté
					echo '<div class="thumbnail stylelien shadow-lg p-3 mb-5 mt-5 rounded">';
					echo affiche_imagecommu($donnecommunaute[0]['image']);
					?>
					<div class="container nomcommu caption img-thumbnail">
						<?php
							// On récupère toutes les données de la communauté
						echo "<h1 class='text-center pagecommu '>" . $communaute .  "</h1>";
						echo '<p class="mx-4 description">' . $donnecommunaute[0]['description'] .  "</p>";

						if ($_SESSION['id']!=$createur[0]['id']) {

						afficheboutonquitter($_SESSION['id'], $idcommu);

						}
						?>
					</div>
					</div>
				</div>
			</div>

			<div class="tab-pane fade" id="tchat" role="tabpanel" aria-labelledby="tchat-tab">
				<!-- <div class="container descriptioncommu caption img-thumbnail mt-4"> -->
					<!-- <h4> TCHAT </h4> -->
					<?php
					//affichemessagecommu($messagesdelacommu);
					print_formulairemessagecommu($idcommu);
					?>
				<!-- </div> -->
			</div>

			<div class="tab-pane fade" id="stats" role="tabpanel" aria-labelledby="stats-tab">
				<div class="container descriptioncommu caption img-thumbnail mt-4 shadow-lg p-3 mb-5 bg-white rounded">

					<?php
						//Affichage de la description
					echo "<h4 class='m-2'> Créateur : </h4> <div class='ml-4'>";
					affichemembre($createur, "id");
							// var_dump($createur);
					echo "</div> <h4 class='m-2'> Membres qui publient le plus : </h4>";
					affichemembrepublieleplus(chargeplusactifpost($idcommu), "idauteur", $idcommu);
					echo "<h4 class='m-2'> Membres qui commentent le plus : </h4>";
					affichemembrecommenteleplus(chargeplusactifcomment($idcommu), "idauteur", $idcommu);
					?>

				</div>
			</div>
			<div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
				<div class="container descriptioncommu caption img-thumbnail mt-4 shadow-lg p-3 mb-5 bg-white rounded">
					<!-- <h4> Voici les membres de la communauté : </h4> -->
					<?php
					afficheabonnée ($membrecommu, "iduser");
					?>
				</div>
			</div>

		<?php if (estmodo($_SESSION['id'], $idcommu)) { ?>
			<div class="tab-pane fade" id="signaler" role="tabpanel" aria-labelledby="signal-tab">
				<div class="container descriptioncommu caption img-thumbnail mt-4">
				
					<?php
					affichebarreadmin();

					echo "<div id='membres'>";
					echo "<h4> Membre de la communauté : </h4>";
					// affichemembrenonmodo($membrecommu, "iduser", $idcommu, $communaute);
					// affichemembrecollapse($membrecommu, $idcommu, $communaute);
					affichemembrenonmodo($membrecommu, "iduser", $idcommu, $communaute);
					echo "</div>";

					echo "<div id='moderation'>";
					echo "<h4> Modérateur : </h4>";
					affichemembremodo($membrecommu, "iduser", $idcommu, $communaute);
					echo "</div>";

					echo "<h4 id='banni'> Membre ban de votre commu : </h4>";
					affichemembredeban($utilisateurbanni, "iduser", $idcommu, $communaute);
					?>

				</div>
			</div>
		<?php } ?>

		<?php if ($_SESSION['id']==$createur[0]['id']) { ?>

			<div class="tab-pane fade " id="admin" role="tabpanel" aria-labelledby="admin-tab">
				<div class="container descriptioncommu caption img-thumbnail mt-4 shadow-lg p-3 mb-5 mt-5 rounded">
				
					<?php

					affichebarreadmin();
					//Supprimer une communauté 
					echo "<div class='container text-center mt-4'>";
					echo "<form method='post' action='index.php?page=communaute'>";
					echo  "<input id='idcommu' name='idcommu' type='hidden' value= ". $idcommu . ">";
					echo  "<input id='nomphoto' name='nomphoto' type='hidden' value= ". $donnecommunaute[0]['image'] . ">";
					echo "<input type='submit' name='delcommu' class='btn btn-danger' value='Supprimer la communauté'/>" . "</p>";
					echo "</form>";
					formulairemodificationnomcommu($communaute, $idcommu);
					formulairemodificationdescriptioncommu($description,$idcommu);
					formulairemodificationimagecommu($idcommu);

					echo  "</div>";





					echo "<div id='membres'>";
					echo "<h4> Membre de la communauté : </h4>";

					// affichemembrenonmodo($membrecommu, "iduser", $idcommu, $communaute);
					// affichemembrecollapse($membrecommu, $idcommu, $communaute);
					affichemembrenonmodo($membrecommu, "iduser", $idcommu, $communaute);
					echo "</div>";

					echo "<div id='moderation'>";
					echo "<h4> Modérateur : </h4>";
					affichemembremodo($membrecommu, "iduser", $idcommu, $communaute);
					echo "</div>";

					echo "<h4 id='banni'> Membre ban de votre commu : </h4>";

					echo "<div id='moderation'>";
					affichemembredeban($utilisateurbanni, "iduser", $idcommu, $communaute);
					echo "</div>";
					echo "<div id='membres'>";
					echo "<h4> Membre de la communauté signalé : </h4>";

					affichemembresignale($membrecommu, "iduser", $idcommu, $communaute);
					
					echo "</div>";
					?>
				</div>
			</div>
			<?php } ?>

			</div>
		</div>
	</div>
</div>
</div>
</div>
</div>
</div>
</div>







<form class="form-group" method="post" action="index.php?page=accueil">
			
								<input type="hidden" name="commu" value= "<?php echo $communaute; ?>">

								<div class="m-3 text-center">
									<button type="submit" name="telechargerpost" value="telechargerpost" class="btn btn-success bi-download"> Télécharger</button>
								</div>
							</form>







	</div>

	<div class="container">
		<h2 class="mt-5 mb-5 mx-3 text-center">Decouvrez les posts des utilisateurs fan de cette Communauté:</h2>
		<?php	
			affichepost($donnepost);
			


		?>

	</div>
</div>

<?php }
else {
		echo '<script>alert("Vous devez être membre de la communauté pour accéder");
	window.location.href = "./index.php?page=communaute";</script>'; 
  	exit();
}

?>



