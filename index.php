<?php
include 'C:\xampp\htdocs\projet\fonction.php';

$films = simplexml_load_file('C:\xampp\htdocs\projet\xml\cinema.xml');
$restaurants = simplexml_load_file('C:\xampp\htdocs\projet\xml\restaurant.xml');
?>
<!DOCTYPE html>
<html>

<head>
    <title>Présentation des Films et Restaurants</title>
    <link rel="stylesheet" type="text/css" href="C:\xampp\htdocs\projet\style.css">
    <style>
        body {
            background: url('') no-repeat center center fixed;
            background-size: cover;
        }
    </style>
</head>

<body>
    <h1>Bienvenue sur notre site GastroCinema</h1>

    <h1>Films</h1>
    <ul>
        <?php foreach ($films->Film as $film) : ?>
            <li>
                <h2><em><?php echo $film->titre; ?></em></h2>
                <p><?php echo $film->description; ?></p>
                <p>Durée: <?php echo $film->duree; ?></p>
                <p>Genre: <?php echo $film->genre; ?></p>
                <p>Réalisateur: <?php echo $film->realisateur; ?></p>
                <p>Acteurs: <?php echo implode(', ', (array)$film->acteurs->acteur); ?></p>
                <p>Année: <?php echo $film->annee; ?></p>
                <p>Langue: <?php echo $film->langue; ?></p>
                <p>Horaires:</p>
                <ul>
                    <?php foreach ($film->horaires->horaire as $horaire) : ?>
                        <li>
                            <strong>Jours:</strong>
                            <?php echo implode(', ', (array)$horaire->jours->jour); ?><br>
                            <strong>Heures:</strong>
                            <?php echo implode(', ', (array)$horaire->heures->heure); ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </li>
        <?php endforeach; ?>


    </ul>

    <h1>Restaurants</h1>
    <ul>
        <?php foreach ($restaurants->Restaurant as $restaurant) : ?>
            <li>
                <h2><em><?php echo $restaurant->infos->nom; ?></em></h2>
                <p>Coordonnées: <?php echo $restaurant->infos->coordonnees; ?></p>
                <p>Adresse: <?php echo $restaurant->infos->adresse; ?></p>
                <p>Nom du Restaurateur: <?php echo $restaurant->infos->nomRestaurateur; ?></p>
                <div>
                    <?php foreach ($restaurant->infos->descriptionRestaurant->paragraphe as $paragraphe) : ?>
                        <p>
                            <?php if ($paragraphe->image) :
                                $imagePath = (string) $paragraphe->image['src'];
                                $imageUrl = 'http://localhost' . str_replace('C:\\xampp\\htdocs', '', $imagePath);
                                $imagePosition = (string) $paragraphe->image['position'];
                            ?>
                                <img src="<?php echo $imageUrl; ?>" alt="Image Restaurant" style="float:<?php echo $imagePosition; ?>; margin: 10px;">
                            <?php endif; ?>
                            <?php echo $paragraphe; ?>
                        </p>
                    <?php endforeach; ?>
                </div>

                <h3>Carte</h3>
                <ul>
                    <?php foreach ($restaurant->carte->plat as $plat) : ?>
                        <li>
                            <strong><?php echo $plat['type']; ?>:</strong>
                            <?php echo $plat->descriptionPlat->paragraphe; ?>
                            (<?php echo $plat['prix']; ?> <?php echo $plat['devise']; ?>)
                        </li>
                    <?php endforeach; ?>
                </ul>

                <?php if ($restaurant->menus->menu) : ?>
                    <h3>Menus</h3>
                    <ul>
                        <?php foreach ($restaurant->menus->menu as $menu) : ?>
                            <li>
                                <strong><?php echo $menu['titre']; ?>:</strong>
                                <?php echo $menu->descriptionMenu->paragraphe; ?>
                                (<?php echo $menu['prix']; ?> <?php echo $menu['devise']; ?>)
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
    </div>



    <a href="login.php">Se connecter</a>
</body>

</html>