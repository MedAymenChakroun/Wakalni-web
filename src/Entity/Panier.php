<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Panier
 *
 * @ORM\Table(name="panier", indexes={@ORM\Index(name="fkclientp", columns={"clientid"}), @ORM\Index(name="fkoffrep", columns={"offreid"}), @ORM\Index(name="fkproduit", columns={"produitid"})})
 * @ORM\Entity
 */
class Panier
{
    /**
     * @var int
     *
     * @ORM\Column(name="panierid", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $panierid;

    /**
     * @var int
     *
     * @ORM\Column(name="quantite", type="integer", nullable=false)
     */
    private $quantite;

 
    
    /**
     * @var \Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="clientid", referencedColumnName="id")
     * })
     */
    private $clientid;
    /**
     * @var int
     *
     * @ORM\Column(name="prixprod", type="integer", nullable=false)
     * 
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $prixprod;

    

    public function getPanierid(): ?int
    {
        return $this->panierid;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

   

    public function getPrixprod(): ?float
    {
        return $this->prixprod;
    }

    public function setPrixprod(float $prixprod): self
    {
        $this->prixprod = $prixprod;

        return $this;
    }

    public function getProduitid(): ?Produit
    {
        return $this->produitid;
    }

    public function setProduitid(?Produit $produitid): self
    {
        $this->produitid = $produitid;

        return $this;
    }

    public function getClientid(): ?Utilisateur
    {
        return $this->clientid;
    }

    public function setClientid(?Utilisateur $clientid): self
    {
        $this->clientid = $clientid;

        return $this;
    }

   
    public function __toString()
    {
        return $this->nomproduit;
    }



}
