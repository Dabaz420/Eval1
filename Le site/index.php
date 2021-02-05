<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- police de google font -->
    <link href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <!-- Twitter card -->
    <!-- Défini le type de twitter card -->
    <meta name=”twitter:card” content="summary" />
    <!-- @nomdusite qui sera afficher au pied de page de la card -->
    <meta name=”twitter:site” content=”@vapeurdouce” />
    <!-- défini le titre de la card -->
    <meta name=”twitter:title” content="VAPEUR DOUCE" />
    <!-- défini la description de la card (avec un solo de guitare pour le STYLE) -->
    <meta name=”twitter:description” content="CHERCHE COMMENT CUIRE TES ALLIMENTS À LA VAPEUR AVEC VAPEUR DOUCE ! MEEYOWEYOWYOWYOWEEYOW !" />
    <!-- défini l'image de la card -->
    <meta name=”twitter:image:src” content="https://damienrodriguez.go.yj.fr/vapeurdouce.jpg" />
    <!-- @nomd'utilisateur du créateur du contenu -->
    <meta name=”twitter:creator” content="@StéphaneGabrielly"/>
    <!-- Open Graph -->
    <!-- défini l'url du site -->
    <meta property="og:url" content="https://damienrodriguez.go.yj.fr/" />
    <!-- défini le type de site -->
    <meta property="og:type" content="website" />
    <!-- défini le titre  -->
    <meta property="og:title" content="VAPEUR DOUCE" />
    <!-- défini la description du site -->
    <meta property="og:description" content="CHERCHE COMMENT CUIRE TES ALLIMENTS À LA VAPEUR AVEC VAPEUR DOUCE ! MEEYOWEYOWYOWYOWEEYOW !" />
    <!-- défini l'image sur l'opengraph -->
    <meta property="og:image" content="https://damienrodriguez.go.yj.fr/vapeurdouce.jpg" />
    <!-- meta pour le référencement -->
    <!-- Titre du site -->
    <title>Vapeur Douce</title>
    <!-- défini la description afficher dans la page resultat du moteur de recherche -->
    <meta name="description" content="VAPEUR DOUCE - Plats à la vapeur, Vapeur Douce"/>
    <!-- défini les mot clef associé au site -->
    <meta name="keywords" content="vapeur, cuisson, recette, vapeur douce, Stéphane Gabrielly, Gabrielly"/>
    <!-- signale au robot des moteurs de recherche qu'ils doivent indexer la page index -->
    <meta name="robots" content="index, follow" />
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
                //// Lorsque je retoune les valeurs de l'API je les passent dans un htmlentities pour éviter les failles XSS
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