<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ReviewRepository;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Review
 *
 * @ORM\Table(name="review", indexes={@ORM\Index(name="fkclientreview", columns={"utilisateurid"}), @ORM\Index(name="fkproduitreview", columns={"produitid"})})
 * @ORM\Entity(repositoryClass=ReviewRepository::class)
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
     * @Assert\NotBlank(message=" non vide")
     * @Assert\Positive
     *
     * @ORM\Column(name="note", type="integer", nullable=false)
     */
    private $note;

    /**
     * @var string
     * @Assert\NotBlank(message=" non vide")
     *
     * @ORM\Column(name="commentaire", type="text", length=65535, nullable=false)
     */
    private $commentaire;

    /**
     * @var \Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="utilisateurid", referencedColumnName="id")
     * })
     */
    private $utilisateurid;

    /**
     * @var \Produit
     *
     * @ORM\ManyToOne(targetEntity="Produit")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="produitid", referencedColumnName="produitid")
     * })
     */
    private $produitid;

    public function getReviewid()
    {
        return $this->reviewid;
    }

    public function getNote()
    {
        return $this->note;
    }

    public function setNote( $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getCommentaire()
    {
        return $this->commentaire;
    }

    public function setCommentaire( $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getUtilisateurid()
    {
        return $this->utilisateurid;
    }

    public function setUtilisateurid( $utilisateurid): self
    {
        $this->utilisateurid = $utilisateurid;

        return $this;
    }

    public function getProduitid()
    {
        return $this->produitid;
    }

    public function setProduitid( $produitid): self
    {
        $this->produitid = $produitid;

        return $this;
    }


}
