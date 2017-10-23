<?php require 'template/head.php';


if (isset($_SESSION['message'])) {
    echo '<p>'.$_SESSION['message'].'</p>';
    unset($_SESSION['message']);
}
    ?>
  <form class="" action="" method="post">
    <input type="submit" value="Changer de perso" name="Changer" class="btn"/>
  </form>
  <p><?php echo $perso->getNom(); ?> est selectionné et a déjà subi <?php echo $perso->getDegats(); ?> dégats.</p>
  <p>Choisissez qui attaquer : </p>
  <?php
  if (count($persos) > 1) {
      ?>
  <form class="" action="" method="post">
    <select class="" name="select">
  <?php
      foreach ($persos as $personnage) {
          ?>
    <option value="<?php echo $personnage->getId(); ?>"><?php echo $personnage->getNom(); ?></option>
    <?php
      } ?>
    </select>
    <?php if ($perso->getType() == 'Magicien') {
          ?>
      <input type="submit" value="Endormir" name="Endormir" class="btn"/>
      <?php } ?>
    <input type="submit" value="Attaquer" name="Attaquer" class="btn"/>
  </form> <?php
  } else {
      echo "Aucun personnages à attaquer.";
  }


require 'template/foot.php'; ?>
