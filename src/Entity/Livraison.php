<?php

namespace App\Entity;

use App\Repository\LivraisonRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LivraisonRepository::class)
 */
class Livraison
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *      @ORM\JoinColumn(name="Livreurid", referencedColumnName="id")
     * })
     * @ORM\JoinColumn(nullable=false)
     */
    private $idlivreur;

    /**
     * @ORM\ManyToOne(targetEntity="Commande")
     * @ORM\JoinColumns({
     *      @ORM\JoinColumn(name="commandeid", referencedColumnName="commandeid")
     * })
     * @ORM\JoinColumn(nullable=false)
     */
    private $idcommande;

    /**
     * @ORM\Column(type="integer")
     */
    private $progress;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdlivreur(): ?user
    {
        return $this->idlivreur;
    }

    public function setIdlivreur(?user $idlivreur): self
    {
        $this->idlivreur = $idlivreur;

        return $this;
    }

    public function getIdcommande(): ?commande
    {
        return $this->idcommande;
    }

    public function setIdcommande(?commande $idcommande): self
    {
        $this->idcommande = $idcommande;

        return $this;
    }

    public function getProgress(): ?int
    {
        return $this->progress;
    }

    public function setProgress(int $progress): self
    {
        $this->progress = $progress;

        return $this;
    }
}
