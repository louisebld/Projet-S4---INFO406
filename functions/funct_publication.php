<?php

function print_formulairecreationpost() {
// Fonction qui affiche le formulaire de création de post
	?>


	<form method="post" action="index.php?page=publication" enctype="multipart/form-data">


		<div class="form-group">
			<input type="file" name="imagepost" class="form-control">
		</div>

		<br/>
		<div class="form-group">
			<textarea class="form-control" name="description" id="description" placeholder="Légende de votre publication" rows="3"><?php if (isset($_SESSION['donnecreatpost']['description'])) echo $_SESSION['donnecreatpost']['description']; ?></textarea>
		</div>

		<input type="hidden" id="idutilisateur" name="idutilisateur" value="<?php if (isset($_SESSION['id'])) {echo $_SESSION['id'];} ?>" />

		<?php
		listederoulcommu();
		?>


		<br/>
		<center><input type="submit" class="btn btn-pritaby" name="poster" id="poster" value="Créer" /></center>

	</form>

	<?php

}


function affiche_imagepost($nomimage){

	return $img = '<img src="./images/post/' . $nomimage . '" alt="post" class="  card-img-top pt-2 img-article-board"/>';

}

function affiche_imagepost_blackwhite($nomimage){

	return $img = '<img src="./images/post/' . $nomimage . '" alt="post" class="card-img-top pt-2 img-article-board p-2" style="filter : blur(7px)"/>';

}


function affichepost($tableaupost){

	// BUT : afficher les communauté

	// $tableaucommu : tableau associatif contenant les infos des communautés

	echo"<div class='container images-wrapper d-flex'>";
		echo "<div class='card-columns'>";

	foreach ($tableaupost as $key => $value) {
		//Affichage


		echo "<div class='col-lg-4 col-md-12 mb-4 text-center width-auto'>";

	if (!estdejaawarenesspost($_SESSION['id'], $value['idpost'])) {
				echo '<div class="btn btn-warning boutonnew disabled" style="cursor:default;">NEW</div>';

			}
			echo '<div class="card" style="width: 18rem;">';
			echo "<a class='stylelien' href=index.php?page=post" . $value['idpost'] . ">";

			

					echo affiche_imagepost($value['image']);
					echo "<div class='text-start'>" . nbLike(getLike(),$value['idpost']) . " ♥" . "</div>"; 
					echo '<div class="caption img-thumbnail">';
						echo $value["description"];
					echo "</div>";
			echo "</div>";
		echo "</div>";

	}
		echo "</div>";
	echo "</div>";
}


function commenceparpost($chaine) {
  if(strpos($chaine, "post" ) === 0){
      return true;
  }else {
      return false;
}

}

function savoirpost($chaine){
	return substr($chaine, 4, (strlen($chaine)-1));

}


function recupdonnepost($idpost){

	global $db;
	$sql = "SELECT * FROM publication WHERE idpost = $idpost";
	$result=  mysqli_query($db, $sql);

	//on met dans un tableau
	$tableau = [];
	while ($row=mysqli_fetch_assoc($result)) {
		$tableau[] = $row;
	}

	return $tableau;


}

function affichebouttonpartage(){
echo "
<p>
<h3>Partager ce post: </h3>
   <div class='form-group d-flex mx-auto'>
   	<input class='form-control w-auto d-flex mx-3 mt-2' type='url' id='lien' value=''/>
	<button type='button' class='btn btn-dark' onclick='copierLien()'>Copier</button>
   </div>
   
</p>
<script>
	 document.getElementById('lien').value = window.location.href;
</script>
";
}


function affichemonpost($donnepost){

	echo affiche_imagepost($donnepost[0]['image']);
	//Pour la description de la publi
	$auteur = recupAuteur(intval(($donnepost[0]['idauteur'])));
	echo '<div class="container mt-2 mb-4 p-4">';
				//$createur = recupdonneauteurcommu($idcommu);
				$createur = recupdonneauteurpost($donnepost[0]["idpost"]);
				echo '<h5 class="card-title">' . affichemembre ($createur, "id") . "</h5>";
				echo '<p class="card-text">' . $donnepost[0]['description'] . '</p>';
				
				//Pour liker le post
				$like = nbLike(getLike(),$donnepost[0]['idpost']);
				$dislike = nbUnlike(getUnlike(),$donnepost[0]['idpost']);
				if (($like+$dislike)==0){
					$ratio=0;
				}else {
					$ratio = ($like / ($like + $dislike)) * 100;
				}
				echo '<div class="text-center">';
					echo '<div class="container">';
					echo '<div class="d-inline-flex">';
							echo afficheLikeBouton($donnepost[0]['idpost']);
							echo '<p class="text-danger mx-2">' . $like . '</p>';
					echo '</div>';
					echo '<div class="d-inline-flex">';
							echo afficheUnlikeBouton($donnepost[0]['idpost']);
							echo '<p class="mx-2">' . $dislike . '</p>';
					echo '</div>';
				if (($like + $dislike)!=0){
					echo '<div class="progress bg-dark">';
						echo '<div class="progress-bar bg-danger" role="progressbar" aria-valuenow="'.$ratio.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$ratio.'%;">';
						echo '</div>';
					echo '</div>';
				}
			echo'</div>';
		echo'</div>';
		
	echo "</div>";
	//Lien de partage
	echo affichebouttonpartage();

	

	
	$idcomu =  $donnepost[0]['idcommu'];
	$idpost = $donnepost[0]['idpost'];

	

}


	//if (isset($_SESSION['connected'])){

// function affichecommentaire ($idcomu, $idpost){
// 		echo '<div class="commentaire">';
// 		echo "<h2>Ajouter un commentaire :</h2>";
// 		form_com($idcomu, $idpost);
// 		echo "</div>";
		
// 		$com = charge_com($idcomu, $idpost);
// 		if (!empty($com)) {
// 				echo '<div class="sectionCommentaire">';
// 				echo "<h2>Commentaire: </h2></br>";	
// 				print_com($com);
// 				echo "</div>";
// 		}
// 	}

function supprimephotopost($nomphoto){
	unlink('images/post/' . $nomphoto);
}

function triFilActuByID($commu){

	
}

function afficheFilActu($mescommu, $iduser){
	//Recuperation des posts selon les differentes communaute
	$tabPost = [];
	$tabPost[] = recuppostByID($mescommu, $iduser);
	$tabPost = $tabPost[0];

	//recupere posts selon ce que les followers ont posté et que l'user n'a pas vu 
	$mesfollow = takefollow($_SESSION['id']);

	//On recupere pour chaque follower ce qu'il a posté/liké mais que l'autre n'a pas vu
	foreach ($mesfollow as $key => $value) {
		$tabPostFollowers = recup_mes_posts_selon_user($value['id'], $iduser);
		$tabPostLikedByFollowers = recup_mes_posts_selon_user_selon_like($value['id'], $iduser);
	}
	//Ajout des resultats dans le tableau de posts a afficher, avec l'id du user qui nous la partage,plus le nom de la commu ou le post est affiché 
	if (!empty($tabPostFollowers)){
		foreach ($tabPostFollowers as $key => $value) {

			$tabPost[] = $value + recupAuteur($value['idauteur']) + recupereNomCommu($value['idcommu']);
		}
	}
	if (!empty($tabPostLikedByFollowers)){
		foreach ($tabPostLikedByFollowers as $key => $value) {

			$tabPost[] = $value + recupAuteur($value['idauteur'])  + recupereNomCommu($value['idcommu']);
		}
	}
	
	//var_dump($tabPost);

	//Tri des posts selon leur ids
	$keys = array_column($tabPost, 'idpost');
	array_multisort($keys, SORT_DESC, $tabPost);

	//On supprime les doublons
	$arResto = array(); // le nouveau tableau dédoublonné
	$arTemp = array(); // contiendra les ids à éviter
	foreach($tabPost as $ar)
	{
		if(!in_array($ar['idpost'], $arTemp)) {
			$arResto[] = $ar;
			$arTemp[] = $ar['idpost'];   
		}
	}
	//On recupere le nouveau tableau trié pour le remettre dans l'ancien
	$tabPost = $arResto;

	echo '<div class="container">';
		echo"<div class='row'>";
			//foreach ($tabPost as $key => $value) {
				//var_dump($value);
				foreach ($tabPost as $key => $value) {
					//var_dump(array_unique($value));
					echo '<div class="col-sm-12 col-lg-7 mx-auto my-4">';	
						echo "<a class='stylelien' href=index.php?page=post" . $value['idpost'] . ">";
							echo '<div class="card">';
									if (isset($value['pseudo'])){
										echo affiche_imagepost_blackwhite($value['image']);
									} else {
										echo affiche_imagepost($value['image']);
									}
									echo '<div class="card-body">';
										echo '<h5 class="card-title">'. $value['description'] .'</h5>';
										if (isset($value['pseudo'])){
											echo '<p class="card-text">Partagé par ' . $value['pseudo'] . '</p>';
											echo '<p class="card-text disabled">A découvrir dans la communauté ' . $value['nom'] . '</p>';
										}	
									echo '</div>';
								echo '</div>';
							echo '</div>';
						echo "</a>";
				}
			//}
		echo '</div>';
	echo '</div>';
}