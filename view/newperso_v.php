<?php require 'template/head.php';
?>
<br><br><br>
<form class="container" action="" method="post">
  <fieldset>
    <legend>Nouveau Personnage</legend>
    <label for="name">Nom : <input id="name" type="text" name="nom" maxlength="50" /></label>
    <select class="" name="typechoice">
      <option value="Magicien">Magicien</option>
      <option value="Guerrier">Guerrier</option>
    </select>
    <input type="submit" value="Créer ce personnage" name="Creer" class="btn"/>
  </fieldset>
</form>
<form class="container" action="" method="post">
  <select name="choseperso">
    <?php
    foreach ($persos as $perso) {
      ?>
      <option value="<?php echo $perso->getId(); ?>"><?php echo $perso->getNom().' ('.$perso->getType().')'; ?></option>
      <?php
    }
    ?>
  </select>
  <input type="submit" value="Utiliser ce personnage" name="Utiliser" class="btn"/>
</form>



<?php require 'template/foot.php'; ?>
