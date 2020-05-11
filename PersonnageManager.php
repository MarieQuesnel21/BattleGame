<?php


class PersonnagesManager {
    private $_db;

    public function __construct($db){
        $this->setDb($db);
    }

    public function delete (Personnage $perso)
    {
        $this->_db->exec('DELETE FROM personnages WHERE id = '.$perso->id().';');
    }


    public function hydrate(array $ligne)
    {

        foreach ( $ligne as $key => $value){
            $method = 'set'.ucfirst($key);
            if (method_exists($this, $method))
            {
                $this->$method($value);
            }
        }

    }

    public function exists($info)
    {
        if (is_int($info))
       {
           $q = $this->_db->prepare('SELECT COUNT(*) FROM personnages WHERE id= :id');
           $q->execute(array(':id' => $info));

           return (bool) $q->fetchColumn();
       }
       $q = $this->_db->prepare('SELECT COUNT(*) FROM personnages WHERE nom= :nom');
       $q->execute(array(':nom' => $info));

       return (bool) $q->fetchColumn();
    }


    public function getOne($info)
    {
        if (is_int($info))
       {
           $q = $this->_db->prepare('SELECT id,nom,degats FROM personnages WHERE id=' .$info);
           $donnees = $q->fetch(PDO::FETCH_ASSOC);

           return new Personnage($donnees);
           new Personnage(array('nom' => $_GET['nom']));
       }

       else
       {
        $q = $this->_db->prepare('SELECT id,nom,degats FROM personnages WHERE nom=' .$info);
        $q->execute(array(':nom' => $info));

        return new Personnage($q->fetch(PDO::FETCH_ASSOC));
        new Personnage(array('nom' => $_GET['nom']));
       }
    }

    public function getList()
    {
        $persos = array();

        $request = $this->_db->query('SELECT id, nom,`force`, degats, niveau,experience FROM personnages ORDER BY nom') ;

        while ( $ligne = $request->fetch(PDO::FETCH_ASSOC))
        {
            $perso[] = new Personnage($ligne);

        }

        return $persos;
    }

    public function update(Personnage $perso)
    {
        $request = $this->_db->prepare('UPDATE personnages SET `force` = :force,
        degats = :degats, niveau = :niveau, experience = :experience WHERE id = :id; ');
    

        $request->bindValue(':force',$perso->getForce(), PDO::PARAM_INT);
        $request->bindValue(':degats',$perso->getDegats(), PDO::PARAM_INT);
        $request->bindValue(':niveau',$perso->getNiveau(), PDO::PARAM_INT);
        $request->bindValue(':experience',$perso->getExperience(), PDO::PARAM_INT);
        $request->bindValue(':id',$perso->getId(), PDO::PARAM_INT);    
        
        $request->execute();
    }

    public function setDB(PDO $db)
    {
        $this->_db = $db;
    }
}
?>