<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Panier
 *
 * @ORM\Table(name="panier", indexes={@ORM\Index(name="fkoffrep", columns={"offreid"}), @ORM\Index(name="fkproduit", columns={"produitid"}), @ORM\Index(name="fkclientp", columns={"clientid"})})
 * @ORM\Entity(repositoryClass="App\Repository\PanierRepository")
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
     * @var string
     *
     * @ORM\Column(name="nomproduit", type="string", length=11, nullable=false)
     */
    private $nomproduit;

    /**
     * @var string
     *
     * @ORM\Column(name="typeprod", type="string", length=11, nullable=false)
     */
    private $typeprod;

    /**
     * @var float
     *
     * @ORM\Column(name="prixprod", type="float", precision=10, scale=0, nullable=false)
     */
    private $prixprod;

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
     * @var \Offre
     *
     * @ORM\ManyToOne(targetEntity="Offre")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="offreid", referencedColumnName="offreid")
     * })
     */
    private $offreid;

    /**
     * @var \Produit
     *
     * @ORM\ManyToOne(targetEntity="Produit")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="produitid", referencedColumnName="produitid")
     * })
     */
    private $produitid;

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

    public function getNomproduit(): ?string
    {
        return $this->nomproduit;
    }

    public function setNomproduit(string $nomproduit): self
    {
        $this->nomproduit = $nomproduit;

        return $this;
    }

    public function getTypeprod(): ?string
    {
        return $this->typeprod;
    }

    public function setTypeprod(string $typeprod): self
    {
        $this->typeprod = $typeprod;

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

    public function getClientid(): ?Utilisateur
    {
        return $this->clientid;
    }

    public function setClientid(?Utilisateur $clientid): self
    {
        $this->clientid = $clientid;

        return $this;
    }

    public function getOffreid(): ?Offre
    {
        return $this->offreid;
    }

    public function setOffreid(?Offre $offreid): self
    {
        $this->offreid = $offreid;

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
    public function __toString()
    {
        return $this->nomproduit;
    }


}
