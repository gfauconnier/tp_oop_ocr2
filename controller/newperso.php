<?php

if ((isset($_POST['nom']) && !empty($_POST['nom']))) {
    $nom = sanitizeStr($_POST['nom']);
    if (isset($_POST['Creer'])) {
        $type = $_POST['typechoice'];

        if ($manager->addPerso($nom, $type)) {
            $perso = $manager->getPerso($nom);
            $_SESSION['message'] = $perso->getNom().' a été créé';
        } else {
            $_SESSION['message'] = $nom.' existe déjà.';
        }
    }
}
if (isset($_POST['Utiliser'])) {
    $nom = $_POST['choseperso'];
    $perso = $manager->getPerso($nom);
    if (!$perso) {
        $_SESSION['message'] = 'Le personnage n\'existe pas';
    }
}
if (isset($perso)) {
    $_SESSION['perso'] = $perso;
    header('Location: .');
}

$persos = $manager->getAllPersos();

include 'view/newperso_v.php';
