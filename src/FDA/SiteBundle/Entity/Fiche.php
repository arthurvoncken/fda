<?php

namespace FDA\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Fiche
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="FDA\SiteBundle\Entity\FicheRepository")
 * @UniqueEntity(fields="titre", message="Une fiche existe déjà sur cette créatrice.")
 */
class Fiche
{
	/**
	* @ORM\OneToMany(targetEntity="FDA\RessourceBundle\Entity\Lien", mappedBy="fiche", orphanRemoval=true, cascade={"all"})
	*/
	private $liens;

	/**
   * @ORM\ManyToMany(targetEntity="FDA\SiteBundle\Entity\Category", cascade={"persist"})
   */
	private $categories;
	
	/**
	* @ORM\OneToOne(targetEntity="FDA\SiteBundle\Entity\Image", cascade={"all"})
	* @Assert\Valid()
	*/
	private $image_titre;

	/**
	* @ORM\OneToOne(targetEntity="FDA\SiteBundle\Entity\Image", cascade={"all",})
	* @Assert\Valid()
	*/
	private $image_ref;

	/**
	* @ORM\OneToOne(targetEntity="FDA\SiteBundle\Entity\Image", cascade={"all"})
	* @Assert\Valid()
	*/
	private $image1;

	/**
	* @ORM\OneToOne(targetEntity="FDA\SiteBundle\Entity\Image", cascade={"all",})
	* @Assert\Valid()
	*/
	private $image2;

	/**
	* @ORM\OneToOne(targetEntity="FDA\SiteBundle\Entity\Image", cascade={"all",})
	* @Assert\Valid()
	*/
	private $image3;

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
     * @ORM\Column(name="titre", type="string", length=50, unique=true)
	 * @Assert\NotBlank
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="bio", type="text", nullable=false)
	 * @Assert\NotBlank
     */
    private $bio;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="text", nullable=false)
	 * @Assert\NotBlank
     */
    private $contenu;
	
    /**
     * @var string
     *
     * @ORM\Column(name="auteur", type="string", length=50)
     */
    private $auteur;	

	/**
     * @var string
     *
     * @ORM\Column(name="published", type="boolean")
     */
    private $published = false;

	public function __construct($username)
	{
		$this->auteur = $username;
		$this->categories = new ArrayCollection();
		$this->liens = new ArrayCollection();
	}
	
	public function addCategory(Category $category)
	{
		// Ici, on utilise l'ArrayCollection vraiment comme un tableau
		$this->categories[] = $category;

		return $this;
	}

	public function removeCategory(Category $category)
	{
		// Ici on utilise une méthode de l'ArrayCollection, pour supprimer la catégorie en argument
		$this->categories->removeElement($category);
	}

	// Notez le pluriel, on récupère une liste de catégories ici !
	public function getCategories()
	{
		return $this->categories;
	}
	
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
     * Set titre
     *
     * @param string $titre
     * @return Fiche
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string 
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set bio
     *
     * @param string $bio
     * @return Fiche
     */
    public function setBio($bio)
    {
        $this->bio = $bio;

        return $this;
    }

    /**
     * Get bio
     *
     * @return string 
     */
    public function getBio()
    {
        return $this->bio;
    }

    /**
     * Set contenu
     *
     * @param string $contenu
     * @return Fiche
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get contenu
     *
     * @return string 
     */
    public function getContenu()
    {
        return $this->contenu;
    }


    /**
     * Set auteur
     *
     * @param string $auteur
     * @return Fiche
     */
    public function setAuteur($auteur)
    {
        $this->auteur = $auteur;

        return $this;
    }

    /**
     * Get auteur
     *
     * @return string 
     */
    public function getAuteur()
    {
        return $this->auteur;
    }

    /**
     * Set published
     *
     * @param boolean $published
     * @return Fiche
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Get published
     *
     * @return boolean 
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * Set image_titre
     *
     * @param \FDA\SiteBundle\Entity\Image $imageTitre
     * @return Fiche
     */
    public function setImageTitre(\FDA\SiteBundle\Entity\Image $imageTitre = null)
    {
        $this->image_titre = $imageTitre;

        return $this;
    }

    /**
     * Get image_titre
     *
     * @return \FDA\SiteBundle\Entity\Image 
     */
    public function getImageTitre()
    {
        return $this->image_titre;
    }

    /**
     * Set image_ref
     *
     * @param \FDA\SiteBundle\Entity\Image $imageRef
     * @return Fiche
     */
    public function setImageRef(\FDA\SiteBundle\Entity\Image $imageRef = null)
    {
        $this->image_ref = $imageRef;

        return $this;
    }

    /**
     * Get image_ref
     *
     * @return \FDA\SiteBundle\Entity\Image 
     */
    public function getImageRef()
    {
        return $this->image_ref;
    }

    /**
     * Set image1
     *
     * @param \FDA\SiteBundle\Entity\Image $image1
     * @return Fiche
     */
    public function setImage1(\FDA\SiteBundle\Entity\Image $image1 = null)
    {
        $this->image1 = $image1;

        return $this;
    }

    /**
     * Get image1
     *
     * @return \FDA\SiteBundle\Entity\Image 
     */
    public function getImage1()
    {
        return $this->image1;
    }

    /**
     * Set image2
     *
     * @param \FDA\SiteBundle\Entity\Image $image2
     * @return Fiche
     */
    public function setImage2(\FDA\SiteBundle\Entity\Image $image2 = null)
    {
        $this->image2 = $image2;

        return $this;
    }

    /**
     * Get image2
     *
     * @return \FDA\SiteBundle\Entity\Image 
     */
    public function getImage2()
    {
        return $this->image2;
    }

    /**
     * Set image3
     *
     * @param \FDA\SiteBundle\Entity\Image $image3
     * @return Fiche
     */
    public function setImage3(\FDA\SiteBundle\Entity\Image $image3 = null)
    {
        $this->image3 = $image3;

        return $this;
    }

    /**
     * Get image3
     *
     * @return \FDA\SiteBundle\Entity\Image 
     */
    public function getImage3()
    {
        return $this->image3;
    }

    /**
     * Add liens
     *
     * @param \FDA\RessourceBundle\Entity\Lien $lien
     * @return Fiche
     */
    public function addLien(\FDA\RessourceBundle\Entity\Lien $lien)
    {	
        $this->liens[] = $lien;
		$lien->setFiche($this);

        return $this;
    }

    /**
     * Remove liens
     *
     * @param \FDA\RessourceBundle\Entity\Lien $lien
     */
    public function removeLien(\FDA\RessourceBundle\Entity\Lien $lien)
    {
        $this->liens->removeElement($lien);
		$lien->setFiche(null);
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
