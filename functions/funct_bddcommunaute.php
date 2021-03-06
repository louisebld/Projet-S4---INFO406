<?php

function insert_commu($nom, $description, $createur, $nomimage) {
	global $db;
	mysqli_query($db, "INSERT INTO communaute(nom, description, idcreateur, image) VALUES ('$nom', '$description', $createur, '$nomimage')");

}

// modératuib

function insert_modo($iduser, $idcommu) {
	global $db;
		mysqli_query($db, "INSERT INTO moderateur(iduser, idcommu) VALUES ($iduser, $idcommu)");
}

function nomcommuutilise($nomcommu) {

	global $db;
	// Je fais une recherche dans la base à partir du nom de la commu
	$namecommu = mysqli_query($db, "SELECT * FROM communaute WHERE nom = '".$nomcommu."'");
	// on compte le nombre de lignes
	$compteur = mysqli_num_rows($namecommu);
	// si on a trouvé un compte qui correspond : >0 : true
	if ($compteur>0) {
		return true;
	}
	else {
	// sinon faux
		return false;
	}

}


function insert_image() {

$imagecommu = $_FILES['imagecom'];
	global $db;
	// mysqli_query($db, "INSERT INTO imagescommu(nom, taille, type, bin) VALUES ($imagecommu['name'], $imagecommu['size'], $imagecommu['type'], file_get_contents($imagecommu['tmp_name'])))");


}


function charge_commu(){
	// BUT : charge_commu : Fonction qui renvoie un tableau des communautées

	global $db;
	$sql = "SELECT * FROM communaute";
	$result=  mysqli_query($db, $sql);

	//on met dans un tableau
	$tableau = [];
	while ($row=mysqli_fetch_assoc($result)) {
		$tableau[] = $row;
	}

	return $tableau;
}

function charge_commuparid($idcreateur){
	// BUT : charge_commu : Fonction qui renvoie un tableau des communautées

	global $db;
	$sql = "SELECT * FROM communaute WHERE idcreateur= $idcreateur";
	$result=  mysqli_query($db, $sql);

	//on met dans un tableau
	$tableau = [];
	while ($row=mysqli_fetch_assoc($result)) {
		$tableau[] = $row;
	}

	return $tableau;
}

function chargesearchcommu($commucherche) {

	global $db;
	$sql = "SELECT * FROM communaute WHERE nom LIKE ('%$commucherche%') ";
	// $sql = "SELECT * FROM communaute WHERE MATCH (nom, description)  AGAINST ('$commucherche' IN BOOLEAN MODE) ";

	$result=  mysqli_query($db, $sql);

	//on met dans un tableau
	$tableau = [];
	while ($row=mysqli_fetch_assoc($result)) {
		$tableau[] = $row;
	}

	return $tableau;


}

function recupdonnecommu($commu){

	global $db;
	$sql = "SELECT * FROM communaute WHERE nom = '$commu'";
	$result=  mysqli_query($db, $sql);

	//on met dans un tableau
	$tableau = [];
	while ($row=mysqli_fetch_assoc($result)) {
		$tableau[] = $row;
	}

	return $tableau;


}



function listederoulcommu() {

// Afficher une liste déroulante des communautés

	
// on prend la variable dans lequel sont stockées les données des métiers
global $tableaumescommu;

echo "<div class='form-group'>
<div class='form-check form-switch'>";
// pour chacun des métiers on le met dans une "case"

for ($i = 0; $i < count($tableaumescommu); $i++){
	$commucourante = $tableaumescommu[$i];

	echo "
	
	<input class='form-check-input' id='flexSwitchCheckDefault' type='checkbox' name='communaute[]' value='".$commucourante['nom']."'>".$commucourante['nom']."<br/>";
    
}

echo "</div>
	</div>";


}

// pour récupérer l'id de la commu à partir de son nom

function recupecommu($com) {
// variable globale base de donnée
	global $db;

	// Je fais une recherche dans la base à partir du métier
	$commu = mysqli_query($db, "SELECT idcommu FROM communaute WHERE nom = '$com'");
	// on selectionne le métier que l'on veut à partir de son nom

	$resultat = mysqli_fetch_assoc($commu);
	// on retourne l'id
	$id=$resultat['idcommu'];

	return $id;
}


function supprime_commu($idcommu) {
		global $db;
		// on supprime
		mysqli_query($db, "DELETE FROM communaute WHERE idcommu = $idcommu");
	}



function recupdonnecommuparid($id){

	global $db;
	$sql = "SELECT * FROM communaute WHERE idcommu = $id";
	$result=  mysqli_query($db, $sql);

	//on met dans un tableau
	$tableau = [];
	while ($row=mysqli_fetch_assoc($result)) {
		$tableau[] = $row;
	}

	return $tableau;


}

function recupereNomCommu($idcommu){
		//Recupere le nom de la commu via son id
		global $db;
		$sql = "SELECT nom FROM communaute WHERE  idcommu=$idcommu";
		$result=  mysqli_query($db, $sql);
		$row=mysqli_fetch_assoc($result);
		return $row;
}

function recupdonneauteurcommu($idcommu) {

	global $db;
	$sql = "SELECT * FROM profil INNER JOIN communaute ON profil.id = communaute.idcreateur WHERE  communaute.idcommu=$idcommu";
	$result=  mysqli_query($db, $sql);
	//on met dans un tableau
	$tableau = [];
	while ($row=mysqli_fetch_assoc($result)) {
		$tableau[] = $row;
	}

	return $tableau;

}


function estbannicommu($iduser, $idcommu) {

global $db;

	$result = mysqli_query($db, "SELECT * FROM ban WHERE iduser=$iduser AND idcommu=$idcommu ");
	// on compte le nombre de lignes
	$compteur = mysqli_num_rows($result);
	// si on a trouvé un compte qui correspond : >0 : true
	if ($compteur>0) {
		return true;
	}
	else {
	// sinon faux
		return false;

}
}


function changernomcommu($nouveaunom, $idcommu){
	global $db;
	$sql = "UPDATE communaute SET nom = '$nouveaunom' WHERE idcommu = $idcommu";
	$results = mysqli_query($db,$sql);

}

function changerdescriptioncommu($nouvelledescription, $idcommu){
	global $db;
	$sql = "UPDATE communaute SET description = '$nouvelledescription' WHERE idcommu = $idcommu";
	$results = mysqli_query($db,$sql);

}

function changerimagecommu($nouvelleimage, $idcommu){
	global $db;
	$sql = "UPDATE communaute SET image = '$nouvelleimage' WHERE idcommu = $idcommu";
	$results = mysqli_query($db,$sql);

}