<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Review
 *
 * @ORM\Table(name="review", indexes={@ORM\Index(name="fkproduitreview", columns={"produitid"}), @ORM\Index(name="fkclientreview", columns={"utilisateurid"})})
 * @ORM\Entity
 */
class Review
{
    /**
     * @var int
     *
     * @ORM\Column(name="reviewid", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $reviewid;

    /**
     * @var int
     *
     * @ORM\Column(name="note", type="integer", nullable=false)
     */
    private $note;

    /**
     * @var string
     *
     * @ORM\Column(name="commentaire", type="text", length=65535, nullable=false)
     */
    private $commentaire;

    /**
     * @var \Produit
     *
     * @ORM\ManyToOne(targetEntity="Produit")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="produitid", referencedColumnName="produitid")
     * })
     */
    private $produitid;

    /**
     * @var \Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="utilisateurid", referencedColumnName="id")
     * })
     */
    private $utilisateurid;

    public function getReviewid(): ?int
    {
        return $this->reviewid;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(int $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(string $commentaire): self
    {
        $this->commentaire = $commentaire;

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

    public function getUtilisateurid(): ?Utilisateur
    {
        return $this->utilisateurid;
    }

    public function setUtilisateurid(?Utilisateur $utilisateurid): self
    {
        $this->utilisateurid = $utilisateurid;

        return $this;
    }


}
