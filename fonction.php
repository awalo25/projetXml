<?php

// Fonction pour ajouter un film à un fichier XML
function ajouterFilm($xmlFile, $nouveauFilm)
{
    $xml = simplexml_load_file($xmlFile);
    $film = $xml->addChild('Film');
    $film->addChild('titre', $nouveauFilm['titre']);
    $film->addChild('duree', $nouveauFilm['duree']);
    $film->addChild('genre', $nouveauFilm['genre']);
    $film->addChild('realisateur', $nouveauFilm['realisateur']);

    $acteurs = $film->addChild('acteurs');
    foreach ($nouveauFilm['acteurs'] as $acteur) {
        $acteurs->addChild('acteur', $acteur);
    }

    $film->addChild('annee', $nouveauFilm['annee']);
    $film->addChild('langue', $nouveauFilm['langue']);
    $film->addChild('description', $nouveauFilm['description']);

    $horaires = $film->addChild('horaires');
    foreach ($nouveauFilm['horaires'] as $horaire) {
        $horaireNode = $horaires->addChild('horaire');
        $jours = $horaireNode->addChild('jours');
        foreach ($horaire['jours'] as $jour) {
            $jours->addChild('jour', $jour);
        }
        $heures = $horaireNode->addChild('heures');
        foreach ($horaire['heures'] as $heure) {
            $heures->addChild('heure', $heure);
        }
    }

    if (!empty($nouveauFilm['notes'])) {
        $notes = $film->addChild('notes');
        if (isset($nouveauFilm['notes']['presse'])) {
            $notes->addChild('presse', $nouveauFilm['notes']['presse']);
        }
        if (isset($nouveauFilm['notes']['spectateur'])) {
            $notes->addChild('spectateur', $nouveauFilm['notes']['spectateur']);
        }
    }

    $xml->asXML($xmlFile);
}

// Fonction pour modifier un film dans un fichier XML
function modifierFilm($xmlFile, $id, $nouveauFilm)
{
    $xml = simplexml_load_file($xmlFile);
    $film = $xml->Film[intval($id)];

    $film->titre = $nouveauFilm['titre'];
    $film->duree = $nouveauFilm['duree'];
    $film->genre = $nouveauFilm['genre'];
    $film->realisateur = $nouveauFilm['realisateur'];

    $film->acteurs = '';
    foreach ($nouveauFilm['acteurs'] as $acteur) {
        $film->acteur->addChild('acteur', $acteur);
    }

    $film->annee = $nouveauFilm['annee'];
    $film->langue = $nouveauFilm['langue'];
    $film->description = $nouveauFilm['description'];

    $film->horaires = '';
    foreach ($nouveauFilm['horaires'] as $horaire) {
        $horaireNode = $film->horaire->addChild('horaire');
        $jours = $horaireNode->addChild('jours');
        foreach ($horaire['jours'] as $jour) {
            $jours->addChild('jour', $jour);
        }
        $heures = $horaireNode->addChild('heures');
        foreach ($horaire['heures'] as $heure) {
            $heures->addChild('heure', $heure);
        }
    }

    if (!empty($nouveauFilm['notes'])) {
        $film->notes = '';
        if (isset($nouveauFilm['notes']['presse'])) {
            $film->note->addChild('presse', $nouveauFilm['notes']['presse']);
        }
        if (isset($nouveauFilm['notes']['spectateur'])) {
            $film->note->addChild('spectateur', $nouveauFilm['notes']['spectateur']);
        }
    }

    $xml->asXML($xmlFile);
}

// Fonction pour supprimer un film d'un fichier XML
function supprimerFilm($xmlFile, $id)
{
    $xml = simplexml_load_file($xmlFile);
    unset($xml->Film[intval($id)]);
    $xml->asXML($xmlFile);
}

// Fonction pour ajouter un restaurant à un fichier XML
function ajouterRestaurant($xmlFile, $nouveauRestaurant)
{
    $xml = simplexml_load_file($xmlFile);
    $restaurant = $xml->addChild('Restaurant');

    $infos = $restaurant->addChild('infos');
    $infos->addChild('coordonnees', $nouveauRestaurant['infos']['coordonnees']);
    $infos->addChild('nom', $nouveauRestaurant['infos']['nom']);
    $infos->addChild('adresse', $nouveauRestaurant['infos']['adresse']);
    $infos->addChild('nomRestaurateur', $nouveauRestaurant['infos']['nomRestaurateur']);

    $descriptionRestaurant = $infos->addChild('descriptionRestaurant');
    foreach ($nouveauRestaurant['infos']['descriptionRestaurant'] as $paragraphe) {
        if (isset($paragraphe['image'])) {
            $imageNode = $descriptionRestaurant->addChild('image');
            $imageNode->addAttribute('src', $paragraphe['image']['src']);
            $imageNode->addAttribute('position', $paragraphe['image']['position']);
        }
        $descriptionRestaurant->addChild('paragraphe', $paragraphe['texte']);
    }

    $carte = $restaurant->addChild('carte');
    foreach ($nouveauRestaurant['carte'] as $plat) {
        $platNode = $carte->addChild('plat');
        $platNode->addAttribute('type', $plat['type']);
        $platNode->addAttribute('prix', $plat['prix']);
        $platNode->addAttribute('devise', $plat['devise']);

        $descriptionPlat = $platNode->addChild('descriptionPlat');
        $descriptionPlat->addChild('paragraphe', $plat['descriptionPlat']);
    }

    $menus = $restaurant->addChild('menus');
    foreach ($nouveauRestaurant['menus'] as $menu) {
        $menuNode = $menus->addChild('menu');
        $menuNode->addAttribute('titre', $menu['titre']);
        $menuNode->addAttribute('prix', $menu['prix']);
        $menuNode->addAttribute('devise', $menu['devise']);

        $descriptionMenu = $menuNode->addChild('descriptionMenu');
        $descriptionMenu->addChild('paragraphe', $menu['descriptionMenu']);
    }

    $xml->asXML($xmlFile);
}

// Fonction pour modifier un restaurant dans un fichier XML
function modifierRestaurant($xmlFile, $id, $nouveauRestaurant)
{
    $xml = simplexml_load_file($xmlFile);
    $restaurant = $xml->Restaurant[intval($id)];

    $restaurant->infos->coordonnees = $nouveauRestaurant['infos']['coordonnees'];
    $restaurant->infos->nom = $nouveauRestaurant['infos']['nom'];
    $restaurant->infos->adresse = $nouveauRestaurant['infos']['adresse'];
    $restaurant->infos->nomRestaurateur = $nouveauRestaurant['infos']['nomRestaurateur'];

    $restaurant->infos->descriptionRestaurant = '';
    foreach ($nouveauRestaurant['infos']['descriptionRestaurant'] as $paragraphe) {
        if (isset($paragraphe['image'])) {
            $imageNode = $restaurant->info->descriptionRestaurant->addChild('image');
            $imageNode->addAttribute('src', $paragraphe['image']['src']);
            $imageNode->addAttribute('position', $paragraphe['image']['position']);
        }
        $restaurant->info->descriptionRestaurant->addChild('paragraphe', $paragraphe['texte']);
    }

    $restaurant->carte = '';
    foreach ($nouveauRestaurant['carte'] as $plat) {
        $platNode = $restaurant->cartes->addChild('plat');
        $platNode->addAttribute('type', $plat['type']);
        $platNode->addAttribute('prix', $plat['prix']);
        $platNode->addAttribute('devise', $plat['devise']);

        $descriptionPlat = $platNode->addChild('descriptionPlat');
        $descriptionPlat->addChild('paragraphe', $plat['descriptionPlat']);
    }

    $restaurant->menus = '';
    foreach ($nouveauRestaurant['menus'] as $menu) {
        $menuNode = $restaurant->menu->addChild('menu');
        $menuNode->addAttribute('titre', $menu['titre']);
        $menuNode->addAttribute('prix', $menu['prix']);
        $menuNode->addAttribute('devise', $menu['devise']);

        $descriptionMenu = $menuNode->addChild('descriptionMenu');
        $descriptionMenu->addChild('paragraphe', $menu['descriptionMenu']);
    }

    $xml->asXML($xmlFile);
}

// Fonction pour supprimer un restaurant d'un fichier XML
function supprimerRestaurant($xmlFile, $id)
{
    $xml = simplexml_load_file($xmlFile);
    unset($xml->Restaurant[intval($id)]);
    $xml->asXML($xmlFile);
}

// Fonction d'authentification de l'administrateur
function authentifierAdmin($username, $password)
{
    $servername = "localhost";
    $username_db = "root"; // Remplacez par votre nom d'utilisateur MySQL
    $password_db = ""; // Remplacez par votre mot de passe MySQL
    $dbname = "mon_projet"; // Remplacez par le nom de votre base de données

    try {
        // Connexion à la base de données MySQL
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username_db, $password_db);

        // Définir le mode d'erreur PDO à exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Préparer la requête SQL pour vérifier l'existence de l'administrateur
        $stmt = $conn->prepare("SELECT id FROM utilisateurs WHERE username = :username AND password = :password");

        // Liaison des paramètres
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);

        // Exécution de la requête
        $stmt->execute();

        // Vérification si l'administrateur existe
        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        // En cas d'erreur, afficher l'erreur
        echo "Erreur de connexion : " . $e->getMessage();
        return false;
    }
}
