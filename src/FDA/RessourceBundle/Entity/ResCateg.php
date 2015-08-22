<?php

namespace FDA\RessourceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ResCateg
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="FDA\RessourceBundle\Entity\ResCategRepository")
 */
class ResCateg
{

	/**
	* @ORM\OneToMany(targetEntity="FDA\RessourceBundle\Entity\Lien", mappedBy="categorie", orphanRemoval=true, cascade={"all"})
	*/
	private $liens;
	
	
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return ResCateg
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->liens = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add liens
     *
     * @param \FDA\RessourceBundle\Entity\Lien $liens
     * @return ResCateg
     */
    public function addLien(\FDA\RessourceBundle\Entity\Lien $liens)
    {
        $this->liens[] = $liens;
		$liens->setCategorie($this);

        return $this;
    }

    /**
     * Remove liens
     *
     * @param \FDA\RessourceBundle\Entity\Lien $liens
     */
    public function removeLien(\FDA\RessourceBundle\Entity\Lien $liens)
    {
        $this->liens->removeElement($liens);
		$liens->setCategorie(null);
    }

    /**
     * Get liens
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLiens()
    {
        return $this->liens;
    }
}
