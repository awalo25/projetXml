<?php
session_start();
include 'C:\xampp\htdocs\projet\fonction.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (authentifierAdmin($username, $password)) {
        $_SESSION['admin'] = true;
        header("Location: admin.php");
        exit();
    } else {
        $erreur = "Nom d'utilisateur ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Connexion Administrateur</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <h1>Connexion Administrateur</h1>
    <?php if (isset($erreur)) : ?>
        <p style="color:red;"><?php echo $erreur; ?></p>
    <?php endif; ?>
    <form action="login.php" method="post">
        <label for="username">Nom d'utilisateur:</label>
        <input type="text" id="username" name="username"><br>
        <label for="password">Mot de passe:</label>
        <input type="password" id="password" name="password"><br>
        <button type="submit">Connexion</button>
    </form>
</body>

</html>