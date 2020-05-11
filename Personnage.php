
<?php

if (isset($_GET['creer']) && isset($_GET['nom']))
{
    $perso = new Personnage(array('nom' => $_GET['nom']));

    if (!$perso->nomValide())
    {
        $message = 'Le nom choisie est invalide';
    }

    elseif ($manager->exists($perso->getNom()))
    {
        $message = 'Le nom du personnage est déja prit';
        unset($perso);
    }

    else
    {
        $manager->add($perso);
    }
}



class Personnage
{
    private $id;
    private $_nom = "Inconunu";
    private $_force  = 20;
    private $_experience = 0;
    private $_degats = 0;
    private $_niveau;

    private static $_compteur;

    const FORCE_PETITE = 20;
    const FORCE_MOYENNE = 50;
    const FORCE_GRANDE = 80;
    
   public function __construct(array $ligne)
    {

    $nom = $ligne['nom'];
	echo '<br/> Voici le constructeur du personnage "'.$nom.'" !';

	$this->setNom($nom);
	$this->setForce(20);
	$this->_degats;
    $this->_experience = 1;
    self::$_compteur++;
    print('<br/> Le personnage n°'.Self::$_compteur.' "' .$this->getNom() . '" est créé !');
    }


    public function add(Personnage $perso)
    {
        $request = $this->_db->prepare('INSERT INTO personnages Set nm = :nom,
        `force` = :force, degats = :degats, niveau = :niveau, experience = :experience;');
        
        $request->bindValue(':nom',$perso->getNom(), PDO::PARAM_STR);
        $request->bindValue(':force',$perso->getForce(), PDO::PARAM_INT);
        $request->bindValue(':degats',$perso->getDegats(), PDO::PARAM_INT);
        $request->bindValue(':niveau',$perso->getNiveau(), PDO::PARAM_INT);
        $request->bindValue(':experience',$perso->getExperience(), PDO::PARAM_INT);

        header('index.php');
    }

    public function nomValide()
    {
        return !empty($this->_nom);
    }

    public function setForce($force)
    {

        if(!is_int($force))
        {
            trigger_error ('La force d\'un personnage doit être un nombre entier' , E_USER_WARNING);
            return;
        }

        if($force > 100)
        {
            trigger_error ('La force d\'un personnage ne peut dépasser 100' , E_USER_WARNING);
            return;
        }

        $this->_force = $force;
    } 

    public function setId($id)
    {
    
        $id = (int) $id;
        
        
        if ($id > 0)
        {
        $this->_id = $id;
        }
    }

    public function setNom($nom)
    {
        if (is_string($nom))
        {
            $this->_nom = $nom;
        }
    }

    public function setDegats($degats)
    {

        if(!is_int($degats))
        {
            trigger_error ('Les dégats d\'un personnage doit être un nombre entier' , E_USER_WARNING);
            return;
        }
        $this->_degats = $degats;
    } 



    public function frapper (Personnage $perseAFrapper)
    {
        $perseAFrapper->_degats += $this->_force;
        print('<br/> Dégats de ' . $perseAFrapper->getNom() . ' = ' .$perseAFrapper->_degats);
    }

    public function gagnerExperience ()
    {
        $this->_experience = $this->_experience + 1 ;
        print('<br/> Expérience de ' . $this->getNom() . ' = ' . $this->_experience);

    }

    public function getExperience(){
        return $this->_experience;
    }


    public function incExperience($exp){
        $this->_experience += $exp;

    }

    public function getDegats(){
        return $this->_degats;
    }

    public function getNom(){
        return $this->_nom;
    }
    public function getNiveau(){
        return $this->_niveau;
    }
    public function getId(){
        return $this->_id;
    }
    public function getForce(){
        return $this->_force;
    }
    public function setNiveau($niveau)
    {
        $niveau = (int) $niveau;
        
        if ($niveau >= 1 && $niveau <= 100)
        {
            $this->_niveau = $niveau;
        }
    }

    public function setExperience($experience)
    {
        $experience = (int) $experience;
        
        if ($experience >= 1 && $experience <= 100)
        {
            $this->_experience = $experience;
        }
    }
  
}
    
?>