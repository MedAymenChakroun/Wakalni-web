<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

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
     * @Groups("api:leftover")
     */
    private $leftoverid;

    /**
     * @var string
     *
     * @ORM\Column(name="sujet", type="string", length=30, nullable=false)
     * @Assert\NotBlank(message="Must be filled")
     * @Assert\Regex(
     *     pattern     = "/^[a-z]+$/i",
     *     htmlPattern = "^[a-zA-Z]+$",
     *     message="{{ value }} doit etre String "
     * )
     * @Groups("api:leftover")
     */
    private $sujet;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=30, nullable=false)
     *  @Assert\NotBlank(message="Must be filled")
     * @Assert\Regex(
     *     pattern     = "/^[a-z]+$/i",
     *     htmlPattern = "^[a-zA-Z]+$",
     *     message="{{ value }} doit etre String "
     * )
     * @Groups("api:leftover")
     */
    private $type;

    /**
     * @var int
     *
     * @ORM\Column(name="quantite", type="integer", nullable=false)

     *       @Assert\NotBlank(message="Must be filled")
     *      @Assert\Positive(message="Must be positive")
     * @Groups("api:leftover")
     */
    private $quantite;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateexpiration", type="datetime", nullable=false)
     * @Groups("api:leftover")
     */
    private $dateexpiration;

    /**
     * @var \Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur::class,inversedBy="Leftovers")
     */
    private $chefrestoid;



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

    /**
     * @return Utilisateur
     */
    public function getChefrestoid(): ?Utilisateur
    {
        return $this->chefrestoid;
    }

    /**
     * @param Utilisateur $chefrestoid
     */
    public function setChefrestoid(?Utilisateur $chefrestoid): void
    {
        $this->chefrestoid = $chefrestoid;
    }




}
