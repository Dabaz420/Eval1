<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Twitter card -->
    <meta name=”twitter:card” content="summary" />
    <meta name=”twitter:site” content=”@vapeurdouce” />
    <meta name=”twitter:title” content="VAPEUR DOUCE" />
    <meta name=”twitter:description” content="CHERCHE COMMENT CUIRE TES ALLIMENTS À LA VAPEUR AVEC VAPEUR DOUCE" />
    <meta name=”twitter:image:src” content="" />
    <meta name=”twitter:creator” content="@StéphaneGabrielly">
    <!-- Open Graph -->
    <meta property="og:url" content="" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="VAPEUR DOUCE" />
    <meta property="og:description" content="CHERCHE COMMENT CUIRE TES ALLIMENTS À LA VAPEUR AVEC VAPEUR DOUCE" />
    <meta property="og:image" content="" />
    <!-- meta pour le référencement -->
    <title>Vapeur Douce</title>
    <meta name="description" content="VAPEUR DOUCE - Plats à la vapeur, Vapeur Douce">
    <meta name="keywords" content="vapeur, cuisson, recette, vapeur douce, Stéphane Gabrielly, Gabrielly">
</head>
<body>
    <h1>VAPEUR DOUCE</h1>

    <form action="" method="POST">
        <input type="text" name="recherche" placeholder="Recherche un aliment" required/>
        <input type="submit" value="Recherche"/>
    </form>

        <?php
        //Je vérifie si l'utilisateur veux lancer une recherche
        if(isset($_REQUEST["recherche"])){
            //je récupère la recherche de l'utilisateur avec un urlencode pour éviter les chinoiserie
            $postfields = urlencode($_REQUEST["recherche"]);
            //Initialisation de la session cURL
            $curl = curl_init();
            //je définie l'url de la page à récuperer avec la variable $postfields 
            //pour rechercher uniquement ce qui correspond avec ce que l'utilisateur à entré
            curl_setopt($curl, CURLOPT_URL, "https://api.hmz.tf/?id=". $postfields ."");
            //Ici je choisi de récupèrer le résultat au lieu de l'afficher
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            //je initialise un nouveau cookie de session pour igniorer les cookies antérieur
            curl_setopt($curl, CURLOPT_COOKIESESSION, true);
            //j'execute la requête
            $resultat = curl_exec($curl);
            //je décode le json pour en faire un tableau associatif
            $resultat = json_decode($resultat, true);
            //Si la requête à réussi j'affiche le résultat
            if($resultat["status"] == "success" && $postfields != "all"){
                //j'ouvre une div pour la misse en forme
                echo("<div>");
                //je retourne le nom de l'alliment
                echo("<h2>" . htmlentities($resultat['message']['nom'], ENT_QUOTES) . "</h2>");
                //je vérifie si il y un trempage
                if(isset($resultat['message']["vapeur"]["trempage"])){
                    //je retourne le trempage si il y en a un 
                    echo("<p>Trempage : ". htmlentities($resultat['message']["vapeur"]["trempage"], ENT_QUOTES) ." </p>");
                }
                //je vérifie si il y un niveau d'eau
                if(isset($resultat['message']["vapeur"]["niveau d'eau"])){
                    //je retourne le niveau d'eau si il y en a un
                    echo("<p>Niveau d'eau : ". htmlentities($resultat['message']["vapeur"]["niveau d'eau"], ENT_QUOTES) ." </p>");
                }
                //je retourne le temps de cuisson
                echo("<p>Temps de cuisson : ". htmlentities($resultat['message']["vapeur"]["cuisson"], ENT_QUOTES) ." </p>");
                echo("</div>");
                
                ////!\
                //// Lorsque je retoune les valeur de l'API je les passe dans un htmlentities pour éviter les faille XSS
                ////!\ 
            }
            //si la requête à échoué
            else{
                //j'affiche ce petit message
                echo"<div>
                        <p>Aucun résultat ne correspond à votre recherche</p>
                    </div>";
                }

                
            //On ferme la session
            curl_close($curl);
        }
        ?>
</body>
</html>