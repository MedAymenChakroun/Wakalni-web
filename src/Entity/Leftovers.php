<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Leftovers
 *
 * @ORM\Table(name="leftovers", indexes={@ORM\Index(name="fkleftover", columns={"crid"})})
 * @ORM\Entity
 */
class Leftovers
{
    /**
     * @var int
     *
     * @ORM\Column(name="leftoverid", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $leftoverid;

    /**
     * @var string
     *
     * @ORM\Column(name="sujet", type="string", length=30, nullable=false)
     */
    private $sujet;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=30, nullable=false)
     */
    private $type;

    /**
     * @var int
     *
     * @ORM\Column(name="quantite", type="integer", nullable=false)
     */
    private $quantite;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateexpiration", type="datetime", nullable=false)
     */
    private $dateexpiration;

    /**
     * @var \Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="crid", referencedColumnName="id")
     * })
     */
    private $crid;

    public function getLeftoverid(): ?int
    {
        return $this->leftoverid;
    }

    public function getSujet(): ?string
    {
        return $this->sujet;
    }

    public function setSujet(string $sujet): self
    {
        $this->sujet = $sujet;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
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

    public function getDateexpiration(): ?\DateTimeInterface
    {
        return $this->dateexpiration;
    }

    public function setDateexpiration(\DateTimeInterface $dateexpiration): self
    {
        $this->dateexpiration = $dateexpiration;

        return $this;
    }

    public function getCrid(): ?Utilisateur
    {
        return $this->crid;
    }

    public function setCrid(?Utilisateur $crid): self
    {
        $this->crid = $crid;

        return $this;
    }


}
