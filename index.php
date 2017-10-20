<?php
require 'service/functions.php';
require 'model/data.php';



if (isset($_POST['Changer'])) {
    echo 'test';
    session_destroy();
    header('Location: .');
} elseif (isset($_POST['Attaquer'])) {
    $perso = $_SESSION['perso'];
    $persos = $manager->getAllPersos();
    $perso_atk = $manager->getPerso($_POST['select']);
    $retour = $perso->frapperPerso($perso_atk);

    switch ($retour) {
      case Personnage::PERSO_SELFATK:
        $_SESSION['message'] = 'Vous attaquer vous-meme n\'est pas productif';
        break;
      case Personnage::PERSO_MORT:
        $_SESSION['message'] = 'Vous avez tué '.$perso_atk->getNom();
        $manager->deletePerso($perso_atk->getId());
        break;
      case Personnage::PERSO_ATK:
        $_SESSION['message'] = 'Vous avez attaqué '.$perso_atk->getNom().' pour 50 dégats<br>';
        $_SESSION['message'] .= $perso_atk->getNom().' a subi '.$perso_atk->getDegats().' dégats au total.';
        $manager->updatePerso($perso_atk);
        break;
    }

} elseif ((isset($_POST['nom']) && !empty($_POST['nom'])) || isset($_SESSION['perso'])) {
    if (isset($_SESSION['perso'])) {
        $perso = $_SESSION['perso'];
    } else {
        $nom = sanitizeStr($_POST['nom']);
        if (isset($_POST['Creer'])) {
            if ($manager->addPerso($nom)) {
                $perso = $manager->getPerso($nom);
                $_SESSION['message'] = $perso->getNom().' a été créé';
            } else {
                $_SESSION['message'] = $nom.' existe déjà.';
            }
        } elseif (isset($_POST['Utiliser'])) {
            $perso = $manager->getPerso($nom);
            if (!$perso) {
                unset($_SESSION['perso']);
                $_SESSION['message'] = 'Le personnage n\'existe pas';
            }
        }
    }
    if ($perso) {
        $_SESSION['perso'] = $perso;
        $persos = $manager->getAllPersos();
    } else {
        unset($_SESSION['perso']);
        header('Location: .');
    }
}

 include 'view/indexv.php';
