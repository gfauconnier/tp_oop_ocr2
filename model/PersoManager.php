<?php

class PersoManager
{
    private $_db;

    // constructor just calls connection to database
    public function __construct($db)
    {
        $this->setDb($db);
    }

    //setters
    private function setDb(PDO $db)
    {
        $this->_db = $db;
    }

    //methods

    // checks if a Personnage exists - id or name are sent thus type of $val is checked before the query
    public function persoExists($val)
    {
        $selector = $this->val_type($val);
        $query = $this->_db->prepare('SELECT id, nom, degats, type, tpsEndormi FROM personnages WHERE '.$selector.' = :val');
        $query->execute(array('val'=>$val));
        $data = $query->fetch();
        if ($data) {
            return true;
        } else {
            return false;
        }
    }

    // returns one Personnage if he exists (depending on name or id -> $val) and creates a new Personnage instance
    public function getPerso($val)
    {
        $selector = $this->val_type($val);
        if ($this->persoExists($val)) {
            $query = $this->_db->prepare('SELECT id, nom, degats, type, tpsEndormi FROM personnages WHERE '.$selector.' = :val');
            $query->execute(array('val'=>$val));
            $data = $query->fetch(PDO::FETCH_ASSOC);
            if ($data['type'] == 'Guerrier') {
                return new Guerrier($data);
            } else {
                return new Magicien($data);
            }
        }
        return false;
    }

    // returns a list of all created characters
    public function getAllPersos()
    {
        $persos = [];
        $query = $this->_db->query('SELECT id, nom, degats, type, tpsEndormi FROM personnages');
        $data = $query->fetchAll(PDO::FETCH_ASSOC);
        foreach ($data as $perso) {
          if ($perso['type'] == 'Guerrier') {
              $persos[] = new Guerrier($perso);
          } else {
              $persos[] = new Magicien($perso);
          }
        }
        return $persos;
    }

    // inserts a new character in databse if it doesn't exist yet
    public function addPerso($nom, $type)
    {
        if (!$this->persoExists($nom)) {
            $query = $this->_db->prepare('INSERT INTO personnages(nom, degats, type, tpsEndormi) VALUES(:nom, 0, :type, 0)');
            $query->execute(array('nom'=>$nom, 'type'=>$type));
            $perso = $this->getPerso($nom);
            return $perso->getNom().' créé.';
        }
        return false;
    }

    // changes the value of the character's degats in the database
    public function updatePerso(Personnage $perso)
    {
        $query = $this->_db->prepare('UPDATE personnages SET tpsEndormi = :tps, degats = :degats WHERE id = :id');
        $query->execute(array('id'=>$perso->getId(),'tps'=>$perso->getTpsEndormi(),'degats'=>$perso->getDegats()));
    }

    // removes the character from the database
    public function deletePerso($id)
    {
        if ($this->persoExists($id)) {
            $query = $this->_db->prepare('DELETE FROM personnages WHERE id = ?');
            $query->execute(array($id));
        }
    }

    // returns the 'type' of sent value
    public function val_type($value)
    {
        return is_numeric($value) ? 'id' : 'nom';
    }
}
