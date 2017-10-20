<?php require 'template/head.php';


if (isset($_SESSION['message'])) {
    echo '<p>'.$_SESSION['message'].'</p>';
    unset($_SESSION['message']);
}
if (isset($_SESSION['perso'])) {
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
      }
     ?>
    </select>
    <input type="submit" value="Attaquer" name="Attaquer" class="btn"/>
  </form> <?php
  } else {
    echo "Aucun personnages à attaquer.";
  }
} else {
        ?>

<form class="" action="" method="post">
    <p>
      <label for="name">Nom : <input id="name" type="text" name="nom" maxlength="50" /></label>
      <input type="submit" value="Créer ce personnage" name="Creer" class="btn"/>
      <input type="submit" value="Utiliser ce personnage" name="Utiliser" class="btn"/>
    </p>
</form>
<?php
    }
 ?>


<?php require 'template/foot.php'; ?>
