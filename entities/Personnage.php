<?php

class Personnage
{
    protected $id;
    protected $nom;
    protected $degats;
    protected $tpsEndormi;
    protected $type;

    const PERSO_SELFATK = 1;
    const PERSO_MORT = 2;
    const PERSO_ATK = 3;
    const PERSO_ENSORC = 4;
    const PERSO_NOMAGIE = 5;
    const PERSO_ENDORMI = 6;

    // constructor
    public function __construct(array $donnees)
    {
        $this->hydrate($donnees);
        $this->setType(static::class);
    }

    // hydrates the object
    public function hydrate(array $donnees)
    {
        foreach ($donnees as $key => $value) {
            $method = 'set'.ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    // setters
    public function setId(int $id)
    {
        $id = (int) $id;
        if ($id > 0) {
            $this->id = $id;
        }
    }
    public function setNom($nom)
    {
        if (is_string($nom) && strlen($nom) <= 30) {
            $this->nom = $nom;
        }
    }
    public function setDegats(int $degats)
    {
        $degats = (int) $degats;
        if ($degats >= 0 && $degats <= 100) {
            $this->degats = $degats;
        }
    }
    public function setTpsEndormi($tpsEndormi)
    {
        $this->tpsEndormi = $tpsEndormi;
    }
    public function setType($type)
    {
        $this->type = $type;
    }

    //getters
    public function getId()
    {
        return $this->id;
    }
    public function getNom()
    {
        return $this->nom;
    }
    public function getDegats()
    {
        return $this->degats;
    }
    public function getTpsEndomi()
    {
        return $this->tpsEndormi;
    }
    public function getType()
    {
        return $this->type;
    }

    //methods

    // gets the atout value depending on current degats
    public function getAtout()
    {
        if ($this->degats >= 0 && $this->degats <= 25) {
            $atout = 4;
        } elseif ($this->degats > 25 && $this->degats <= 50) {
            $atout = 3;
        } elseif ($this->degats > 50 && $this->degats <= 75) {
            $atout = 2;
        } elseif ($this->degats > 75 && $this->degats <= 90) {
            $atout = 1;
        } else {
            $atout = 0;
        }
        return $atout;
    }

    // takes a Personnage as parameter and calls takeDamage of it
    public function frapperPerso(Personnage $perso)
    {
        if ($this->estEndormi()) {
            return self::PERSO_ENDORMI;
        }
        if ($perso->getNom() != $this->getNom()) {
            return $perso->takeDamage();
        } else {
            return self::PERSO_SELFATK;
        }
    }

    // adds degats to this object
    public function takeDamage()
    {
        $this->degats += 50;
        if ($this->degats < 100) {
            return self::PERSO_ATK;
        } else {
            return self::PERSO_MORT;
        }
    }

    public function estEndormi()
    {
        return $this->$tpsEndormi > time();
    }
}
