<?php

class Guerrier extends Personnage
{

  // adds degats potentially reduced by the atout value
  public function takeDamage()
  {
      $atout = $this->getAtout();
      $this->degats += (50 - ($atout*5));
      if ($this->degats < 100) {
          return self::PERSO_ATK;
      } else {
          return self::PERSO_MORT;
      }
  }
}
