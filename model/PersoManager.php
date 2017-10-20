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
        $query = $this->_db->prepare('SELECT id, nom, degats FROM personnages WHERE '.$selector.' = :val');
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
            $query = $this->_db->prepare('SELECT id, nom, degats FROM personnages WHERE '.$selector.' = :val');
            $query->execute(array('val'=>$val));
            $data = $query->fetch(PDO::FETCH_ASSOC);
            return new Personnage($data);
        }
        return false;
    }

    // returns a list of all created characters
    public function getAllPersos()
    {
        $persos = [];
        $query = $this->_db->query('SELECT id, nom, degats FROM personnages');
        $data = $query->fetchAll(PDO::FETCH_ASSOC);
        foreach ($data as $perso) {
            $persos[] = new Personnage($perso);
        }
        return $persos;
    }

    // inserts a new character in databse if it doesn't exist yet
    public function addPerso($nom)
    {
        if (!$this->persoExists($nom)) {
            $query = $this->_db->prepare('INSERT INTO personnages(nom, degats) VALUES(:nom, 0)');
            $query->execute(array('nom'=>$nom));
            $perso = $this->getPerso($nom);
            return $perso->getNom().' créé.';
        }
        return false;
    }

    // changes the value of the character's degats in the database
    public function updatePerso(Personnage $perso)
    {
        $query = $this->_db->prepare('UPDATE personnages SET nom = :nom, degats = :degats WHERE id = :id');
        $query->execute(array('id'=>$perso->getId(),'nom'=>$perso->getNom(),'degats'=>$perso->getDegats()));
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
