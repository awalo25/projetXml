<?php
session_start();
include 'C:\xampp\htdocs\projet\fonction.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

$films = simplexml_load_file('C:\xampp\htdocs\projet\xml\cinema.xml');
$restaurants = simplexml_load_file('C:\xampp\htdocs\projet\xml\restaurant.xml');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['ajouterFilm'])) {
        $nouveauFilm = [
            'titre' => $_POST['titre'],
            'duree' => $_POST['duree'],
            'genre' => $_POST['genre'],
            'realisateur' => $_POST['realisateur'],
            'acteurs' => explode(',', $_POST['acteurs']),
            'annee' => $_POST['annee'],
            'langue' => $_POST['langue'],
            'description' => $_POST['description'],
            'horaires' => json_decode($_POST['horaires'], true),
            'notes' => json_decode($_POST['notes'], true)
        ];

        ajouterFilm('C:\xampp\htdocs\projet\xml\cinema.xml', $nouveauFilm);
    } elseif (isset($_POST['modifierFilm'])) {
        $id = $_POST['id'];
        $nouveauFilm = [
            'titre' => $_POST['titre'],
            'duree' => $_POST['duree'],
            'genre' => $_POST['genre'],
            'realisateur' => $_POST['realisateur'],
            'acteurs' => explode(',', $_POST['acteurs']),
            'annee' => $_POST['annee'],
            'langue' => $_POST['langue'],
            'description' => $_POST['description'],
            'horaires' => json_decode($_POST['horaires'], true),
            'notes' => json_decode($_POST['notes'], true)
        ];

        modifierFilm('C:\xampp\htdocs\projet\xml\cinema.xml', $id, $nouveauFilm);
    } elseif (isset($_POST['supprimerFilm'])) {
        $id = $_POST['id'];
        supprimerFilm('C:\xampp\htdocs\projet\xml\cinema.xml', $id);
    } elseif (isset($_POST['ajouterRestaurant'])) {
        $nouveauRestaurant = [
            'infos' => [
                'coordonnees' => $_POST['coordonnees'],
                'nom' => $_POST['nom'],
                'adresse' => $_POST['adresse'],
                'nomRestaurateur' => $_POST['nomRestaurateur'],
                'descriptionRestaurant' => explode("\n", $_POST['descriptionRestaurant'])
            ],
            'carte' => json_decode($_POST['carte'], true),
            'menus' => json_decode($_POST['menus'], true)
        ];

        ajouterRestaurant('C:\xampp\htdocs\projet\xml\restaurant.xml', $nouveauRestaurant);
    } elseif (isset($_POST['modifierRestaurant'])) {
        $id = $_POST['id'];
        $nouveauRestaurant = [
            'infos' => [
                'coordonnees' => $_POST['coordonnees'],
                'nom' => $_POST['nom'],
                'adresse' => $_POST['adresse'],
                'nomRestaurateur' => $_POST['nomRestaurateur'],
                'descriptionRestaurant' => explode("\n", $_POST['descriptionRestaurant'])
            ],
            'carte' => json_decode($_POST['carte'], true),
            'menus' => json_decode($_POST['menus'], true)
        ];

        modifierRestaurant('C:\xampp\htdocs\projet\xml\restaurant.xml', $id, $nouveauRestaurant);
    } elseif (isset($_POST['supprimerRestaurant'])) {
        $id = $_POST['id'];
        supprimerRestaurant('C:\xampp\htdocs\projet\xml\restaurant.xml', $id);
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Gestion des Films et Restaurants</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <h1>Gestion des Films</h1>
    <form action="admin.php" method="post">
        <h2>Ajouter un Film</h2>
        <input type="hidden" name="ajouterFilm" value="true">
        <label for="titre">Titre:</label>
        <input type="text" id="titre" name="titre"><br>
        <label for="duree">Durée:</label>
        <input type="text" id="duree" name="duree"><br>
        <label for="genre">Genre:</label>
        <input type="text" id="genre" name="genre"><br>
        <label for="realisateur">Réalisateur:</label>
        <input type="text" id="realisateur" name="realisateur"><br>
        <label for="acteurs">Acteurs (séparés par des virgules):</label>
        <input type="text" id="acteurs" name="acteurs"><br>
        <label for="annee">Année:</label>
        <input type="text" id="annee" name="annee"><br>
        <label for="langue">Langue:</label>
        <input type="text" id="langue" name="langue"><br>
        <label for="description">Description:</label>
        <textarea id="description" name="description"></textarea><br>
        <label for="horaires">Horaires (JSON):</label>
        <textarea id="horaires" name="horaires"></textarea><br>
        <label for="notes">Notes (JSON):</label>
        <textarea id="notes" name="notes"></textarea><br>
        <button type="submit">Ajouter</button>
    </form>

    <h2>Modifier ou Supprimer un Film</h2>
    <ul>
        <?php foreach ($films->Film as $film) : ?>
            <li>
                <form action="admin.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $film['id']; ?>">
                    <label for="titre-<?php echo $film['id']; ?>">Titre:</label>
                    <input type="text" id="titre-<?php echo $film['id']; ?>" name="titre" value="<?php echo $film->titre; ?>"><br>
                    <label for="duree-<?php echo $film['id']; ?>">Durée:</label>
                    <input type="text" id="duree-<?php echo $film['id']; ?>" name="duree" value="<?php echo $film->duree; ?>"><br>
                    <label for="genre-<?php echo $film['id']; ?>">Genre:</label>
                    <input type="text" id="genre-<?php echo $film['id']; ?>" name="genre" value="<?php echo $film->genre; ?>"><br>
                    <label for="realisateur-<?php echo $film['id']; ?>">Réalisateur:</label>
                    <input type="text" id="realisateur-<?php echo $film['id']; ?>" name="realisateur" value="<?php echo $film->realisateur; ?>"><br>
                    <label for="acteurs-<?php echo $film['id']; ?>">Acteurs (séparés par des virgules):</label>
                    <input type="text" id="acteurs-<?php echo $film['id']; ?>" name="acteurs" value="<?php echo implode(',', (array)$film->acteurs->acteur); ?>"><br>
                    <label for="annee-<?php echo $film['id']; ?>">Année:</label>
                    <input type="text" id="annee-<?php echo $film['id']; ?>" name="annee" value="<?php echo $film->annee; ?>"><br>
                    <label for="langue-<?php echo $film['id']; ?>">Langue:</label>
                    <input type="text" id="langue-<?php echo $film['id']; ?>" name="langue" value="<?php echo $film->langue; ?>"><br>
                    <label for="description-<?php echo $film['id']; ?>">Description:</label>
                    <textarea id="description-<?php echo $film['id']; ?>" name="description"><?php echo $film->description; ?></textarea><br>
                    <label for="horaires-<?php echo $film['id']; ?>">Horaires (JSON):</label>
                    <textarea id="horaires-<?php echo $film['id']; ?>" name="horaires"><?php echo json_encode((array)$film->horaires); ?></textarea><br>
                    <label for="notes-<?php echo $film['id']; ?>">Notes (JSON):</label>
                    <textarea id="notes-<?php echo $film['id']; ?>" name="notes"><?php echo json_encode((array)$film->notes); ?></textarea><br>
                    <button type="submit" name="modifierFilm">Modifier</button>
                    <button type="submit" name="supprimerFilm">Supprimer</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>

    <h1>Gestion des Restaurants</h1>
    <form action="admin.php" method="post">
        <h2>Ajouter un Restaurant</h2>
        <input type="hidden" name="ajouterRestaurant" value="true">
        <label for="coordonnees">Coordonnées:</label>
        <input type="text" id="coordonnees" name="coordonnees"><br>
        <label for="nom">Nom:</label>
        <input type="text" id="nom" name="nom"><br>
        <label for="adresse">Adresse:</label>
        <input type="text" id="adresse" name="adresse"><br>
        <label for="nomRestaurateur">Nom du Restaurateur:</label>
        <input type="text" id="nomRestaurateur" name="nomRestaurateur"><br>
        <label for="descriptionRestaurant">Description (séparée par des sauts de ligne):</label>
        <textarea id="descriptionRestaurant" name="descriptionRestaurant"></textarea><br>
        <label for="carte">Carte (JSON):</label>
        <textarea id="carte" name="carte"></textarea><br>
        <label for="menus">Menus (JSON):</label>
        <textarea id="menus" name="menus"></textarea><br>
        <button type="submit">Ajouter</button>
    </form>

    <h2>Modifier ou Supprimer un Restaurant</h2>
    <ul>
        <?php foreach ($restaurants->Restaurant as $restaurant) : ?>
            <li>
                <form action="admin.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $restaurant['id']; ?>">
                    <label for="coordonnees-<?php echo $restaurant['id']; ?>">Coordonnées:</label>
                    <input type="text" id="coordonnees-<?php echo $restaurant['id']; ?>" name="coordonnees" value="<?php echo $restaurant->infos->coordonnees; ?>"><br>
                    <label for="nom-<?php echo $restaurant['id']; ?>">Nom:</label>
                    <input type="text" id="nom-<?php echo $restaurant['id']; ?>" name="nom" value="<?php echo $restaurant->infos->nom; ?>"><br>
                    <label for="adresse-<?php echo $restaurant['id']; ?>">Adresse:</label>
                    <input type="text" id="adresse-<?php echo $restaurant['id']; ?>" name="adresse" value="<?php echo $restaurant->infos->adresse; ?>"><br>
                    <label for="nomRestaurateur-<?php echo $restaurant['id']; ?>">Nom du Restaurateur:</label>
                    <input type="text" id="nomRestaurateur-<?php echo $restaurant['id']; ?>" name="nomRestaurateur" value="<?php echo $restaurant->infos->nomRestaurateur; ?>"><br>
                    <label for="descriptionRestaurant-<?php echo $restaurant['id']; ?>">Description (séparée par des sauts de ligne):</label>
                    <textarea id="descriptionRestaurant-<?php echo $restaurant['id']; ?>" name="descriptionRestaurant"><?php echo implode("\n", (array)$restaurant->infos->descriptionRestaurant->paragraphe); ?></textarea><br>
                    <label for="carte-<?php echo $restaurant['id']; ?>">Carte (JSON):</label>
                    <textarea id="carte-<?php echo $restaurant['id']; ?>" name="carte"><?php echo json_encode((array)$restaurant->carte); ?></textarea><br>
                    <label for="menus-<?php echo $restaurant['id']; ?>">Menus (JSON):</label>
                    <textarea id="menus-<?php echo $restaurant['id']; ?>" name="menus"><?php echo json_encode((array)$restaurant->menus); ?></textarea><br>
                    <button type="submit" name="modifierRestaurant">Modifier</button>
                    <button type="submit" name="supprimerRestaurant">Supprimer</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>

    <a href="logout.php">Déconnexion</a>
</body>

</html>