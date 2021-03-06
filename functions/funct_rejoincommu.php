<?php



function modalrejointcommu($idcommunaute){
	?>

			<button type="button" class="btn btn-light btn-outline-dark border-light m-2" data-bs-toggle="modal" data-bs-target="#connexionButton" data-bs-whatever="@getbootstrap">Rejoindre</button>

			<div class="modal fade" id="connexionButton" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-body">

							<form class="form-group" method="post" action="index.php?page=accueil">
			
								<input type="text" name="idcommu" value= "<?php echo $idcommunaute; ?>">

								<div class="mb-3 text-center">
									<button type="submit" name="rejoindrecommu" value="rejoindrecommu" class="btn btn-success">Rejoindre la communauté</button>
								</div>
							</form>
						</div>
<!-- 						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
						</div>
 -->					</div>
				</div>
			</div>



	<?php
}


function formulairerejointcommu($idcommunaute) {
// Fonction qui affiche le formulaire de création de communauté
	?>


<form class="form-group" method="post" action="index.php?page=accueil">

		<input type="hidden" name="idcommu" value= "<?php echo $idcommunaute; ?>">

		<div class="mb-3 text-center">
			<button type="submit" name="rejoindrecommu" value="rejoindrecommu" class="btn btn-success">Rejoindre la communauté</button>
		</div>
	</form>

	<?php

}


