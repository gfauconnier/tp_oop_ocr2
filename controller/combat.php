<?php

$perso = $_SESSION['perso'];

if (isset($_POST['Changer'])) {
    session_destroy();
    header('Location: .');
}
if (isset($_POST['Attaquer']) || isset($_POST['Endormir'])) {
    $perso = $_SESSION['perso'];
    $perso_atk = $manager->getPerso($_POST['select']);
    if (isset($_POST['Attaquer'])) {
      $retour = $perso->frapperPerso($perso_atk);
    } else{
      $retour = $perso->endormir($perso_atk);
    }

    switch ($retour) {
     case Personnage::PERSO_ENDORMI:
      $_SESSION['message'] = 'Vous êtes endormi et ne pouvez pas attaquer.';
      break;
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
     case Personnage::PERSO_NOMAGIE:
      $_SESSION['message'] = 'Vous n\'avez pas de Magie';
      break;
     case Personnage::PERSO_ENSORC:
      $_SESSION['message'] = 'Vous avez endormi '.$perso_atk->getNom();
      $manager->updatePerso($perso_atk);
      break;
   }
}

$persos = $manager->getAllPersos();


include 'view/combat_v.php';
