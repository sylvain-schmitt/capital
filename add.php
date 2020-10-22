<?php
//connection a la base de donnée
try{
    $bdd = new PDO('mysql:host=localhost;dbname=capital', 'devil', 'azia01');
    $bdd-> exec('SET NAMES "UTF8"');
}catch(PDOException $e){
    echo 'erreur' . $e->getMessage();
}


    //on récupère les données via le formulaire et on vérifie qu'il ne soit pas vide
    if(isset($_POST['capital']) && !empty($_POST['capital'])
    && isset($_POST['pays']) && !empty($_POST['pays'])){

        // On nettoie les données envoyées
        $capital = strip_tags($_POST['capital']);
        $pays = strip_tags($_POST['pays']);

        //on prépare la requète à insérrer et onla sauvegarde dans une variable 
        $query = $bdd->prepare("INSERT INTO liste (capital, pays) VALUES (:capital, :pays)");

        //assigne la valeur de la variable à la colone associée
        $query->bindValue(':capital', $capital);
        $query->bindValue(':pays', $pays);

        //execute la requète
        $query->execute();
        
        //redirige sur la page d'index
        header('Location: /index.php');
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
            <h1>Ajouter une entrée</h1>
            <form method="post">
                <div class="form-group">
                    <label for="capital">Capital</label>
                    <input type="text" id="capital" name="capital" class="form-control">
                </div>
                <div class="form-group">
                    <label for="pays">Pays</label>
                    <input type="text" id="pays" name="pays" class="form-control">
                </div>
                <button class="btn btn-primary">Envoyer</button>
            </form>
        </div>
</body>
</html>