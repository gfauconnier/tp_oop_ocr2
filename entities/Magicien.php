<?php

class Magicien extends Personnage
{

  const PERSO_NOMAGIE = 5;

  public function endormir($perso)
  {

    if ($perso->getId() == $this->getId()) {
      return self::PERSO_SELFATK;
    }
    if($this->getAtout() == 0) {
      return self::PERSO_NOMAGIE;
    }
    if($this->estEndormi()) {
      return self::PERSO_ENDORMI;
    }

    $tps = time() + ($this->getAtout() * 6) * 3600;
    $perso->setTpsEndormi($tps);

    return self::PERSO_ENSORC;
  }

}
