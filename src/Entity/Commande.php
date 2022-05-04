<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommandeRepository::class)
 */
class Commande
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $datecreation;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateexpiration;


    /**
    @var \Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *      @ORM\JoinColumn(name="clientid", referencedColumnName="id")
     * })
     */
    private $clientid;

    public function getid(): ?int
    {
        return $this->id;
    }

    public function getDatecreation(): ?\DateTimeInterface
    {
        return $this->datecreation;
    }

    public function setDatecreation(?\DateTimeInterface $datecreation): self
    {
        $this->datecreation = $datecreation;

        return $this;
    }

    public function getDateexpiration(): ?\DateTimeInterface
    {
        return $this->dateexpiration;
    }

    public function setDateexpiration(?\DateTimeInterface $dateexpiration): self
    {
        $this->dateexpiration = $dateexpiration;

        return $this;
    }

    public function getDatearrivee(): ?\DateTimeInterface
    {
        return $this->datearrivee;
    }

    public function setDatearrivee(?\DateTimeInterface $datearrivee): self
    {
        $this->datearrivee = $datearrivee;

        return $this;
    }


    public function getClientid(): ?user
    {
        return $this->clientid;
    }

    public function setClientid(?user $clientid): self
    {
        $this->clientid = $clientid;

        return $this;
    }
}
