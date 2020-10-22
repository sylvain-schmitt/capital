<?php
//connection a la base de donnée
try{
    $bdd = new PDO('mysql:host=localhost;dbname=capital', 'devil', 'azia01');
    $bdd-> exec('SET NAMES "UTF8"');
}catch(PDOException $e){
    echo 'erreur' . $e->getMessage();
}

//on selectionne toutes les données de table liste 
$liste = "SELECT * FROM liste";
// on prepare la requete sql
$sql = $bdd->prepare($liste);
// On exécute la requete
$sql->execute();
//on stocke la requete dans un tableau
$results = $sql->fetchAll();
//on recupère la capital en fonction du paramètre en GET
if(isset($_GET['capital'])){
    //on stock la capital dans une variable
    $capital = $_GET['capital'];
    //on selectionne le pays en fonction de la capital envoyer en GET avec une condition WHERE
    $query = $bdd->prepare("SELECT pays FROM liste WHERE capital = :capital");
    $query->bindParam(':capital', $capital);
    $query->execute();
    $country = $query->fetch();
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <title>Capital</title>
</head>
<body>
<div class="container">
    <h1 class="text-center">Les capitales !</h1>
            <form  action="" method="GET">
                <div class="form-group">
                    <select class="custom-select" name="capital">
                     <option value="">--choisir une ville--</option>
                        <!--on boucle sur le tableau pour recupérer la valeur envoyer en GET-->
                        <?php foreach($results as $item): ?>
                        <option value="<?= $item['capital'] ?>"><?= $item["capital"] ?></option>
                        <?php endforeach; ?>                
                    </select>
                    <h1> <?= $capital ?> est la capital du pays <?= $country['pays'] ?></h1>
                </div>
                <button class="btn btn-primary">Envoyer</button>
            </form>
    <a href="/add.php">Ajouter une entrée</a>
</div>
</body>
</html>

