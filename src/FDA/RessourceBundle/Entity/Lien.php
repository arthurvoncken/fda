<?php

namespace FDA\RessourceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Lien
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="FDA\RessourceBundle\Entity\LienRepository")
 */
class Lien
{
	/**
	* @ORM\ManyToOne(targetEntity="FDA\RessourceBundle\Entity\ResCateg", inversedBy="liens")
	*/
	private $categorie;

	/**
	* @ORM\ManyToOne(targetEntity="FDA\SiteBundle\Entity\Fiche", inversedBy="liens")
	*/
	private $fiche;	
	
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
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;
	
	/**
     * @var string
     *
     * @ORM\Column(name="alt", type="string", length=255)
     */
    private $alt;


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
     * Set url
     *
     * @param string $url
     * @return Lien
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set alt
     *
     * @param string $alt
     * @return Lien
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;

        return $this;
    }

    /**
     * Get alt
     *
     * @return string 
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * Set categorie
     *
     * @param \FDA\RessourceBundle\Entity\ResCateg $categorie
     * @return Lien
     */
    public function setCategorie(\FDA\RessourceBundle\Entity\ResCateg $categorie = null)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get categorie
     *
     * @return \FDA\RessourceBundle\Entity\ResCateg 
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * Set fiche
     *
     * @param \FDA\SiteBundle\Entity\Fiche $fiche
     * @return Lien
     */
    public function setFiche(\FDA\SiteBundle\Entity\Fiche $fiche = null)
    {
        $this->fiche = $fiche;

        return $this;
    }

    /**
     * Get fiche
     *
     * @return \FDA\SiteBundle\Entity\Fiche 
     */
    public function getFiche()
    {
        return $this->fiche;
    }
}
