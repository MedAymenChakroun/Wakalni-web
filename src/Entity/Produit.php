<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProduitRepository;

/**
 * Produit
 *
 * @ORM\Table(name="produit", indexes={@ORM\Index(name="fkcrp", columns={"crid"})})
 * @ORM\Entity(repositoryClass=ProduitRepository::class)
 */
class Produit
{
    /**
     * @var int
     *
     * @ORM\Column(name="produitid", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $produitid;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=30, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=30, nullable=false)
     */
    private $type;

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float", precision=10, scale=0, nullable=false)
     */
    private $prix;

    /**
     * @var \Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="crid", referencedColumnName="id")
     * })
     */
    private $crid;

    public function getProduitid()
    {
        return $this->produitid;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function setNom( $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType( $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getPrix()
    {
        return $this->prix;
    }

    public function setPrix( $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getCrid()
    {
        return $this->crid;
    }

    public function setCrid( $crid): self
    {
        $this->crid = $crid;

        return $this;
    }


}
