<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commande
 *
 * @ORM\Table(name="commande", indexes={@ORM\Index(name="fkpanier", columns={"panierid"}), @ORM\Index(name="fkclient", columns={"clientid"}), @ORM\Index(name="fklivreur", columns={"livreurid"}), @ORM\Index(name="fkrc", columns={"rcid"})})
 * @ORM\Entity
 */
class Commande
{
    /**
     * @var int
     *
     * @ORM\Column(name="commandeid", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $commandeid;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="datecreation", type="datetime", nullable=true)
     */
    private $datecreation;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="dateexpedition", type="datetime", nullable=true)
     */
    private $dateexpedition;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="datearrivee", type="datetime", nullable=true)
     */
    private $datearrivee;

    /**
     * @var string
     *
     * @ORM\Column(name="nomclient", type="string", length=11, nullable=false)
     */
    private $nomclient;

    /**
     * @var string
     *
     * @ORM\Column(name="nomlivreur", type="string", length=11, nullable=false)
     */
    private $nomlivreur;

    /**
     * @var string
     *
     * @ORM\Column(name="nomresto", type="string", length=11, nullable=false)
     */
    private $nomresto;

    /**
     * @var \Panier
     *
     * @ORM\ManyToOne(targetEntity="Panier")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="panierid", referencedColumnName="panierid")
     * })
     */
    private $panierid;

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
     * @var \Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="livreurid", referencedColumnName="id")
     * })
     */
    private $livreurid;

    /**
     * @var \Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="rcid", referencedColumnName="id")
     * })
     */
    private $rcid;

    public function getCommandeid(): ?int
    {
        return $this->commandeid;
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

    public function getDateexpedition(): ?\DateTimeInterface
    {
        return $this->dateexpedition;
    }

    public function setDateexpedition(?\DateTimeInterface $dateexpedition): self
    {
        $this->dateexpedition = $dateexpedition;

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

    public function getNomclient(): ?string
    {
        return $this->nomclient;
    }

    public function setNomclient(string $nomclient): self
    {
        $this->nomclient = $nomclient;

        return $this;
    }

    public function getNomlivreur(): ?string
    {
        return $this->nomlivreur;
    }

    public function setNomlivreur(string $nomlivreur): self
    {
        $this->nomlivreur = $nomlivreur;

        return $this;
    }

    public function getNomresto(): ?string
    {
        return $this->nomresto;
    }

    public function setNomresto(string $nomresto): self
    {
        $this->nomresto = $nomresto;

        return $this;
    }

    public function getPanierid(): ?Panier
    {
        return $this->panierid;
    }

    public function setPanierid(?Panier $panierid): self
    {
        $this->panierid = $panierid;

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

    public function getLivreurid(): ?Utilisateur
    {
        return $this->livreurid;
    }

    public function setLivreurid(?Utilisateur $livreurid): self
    {
        $this->livreurid = $livreurid;

        return $this;
    }

    public function getRcid(): ?Utilisateur
    {
        return $this->rcid;
    }

    public function setRcid(?Utilisateur $rcid): self
    {
        $this->rcid = $rcid;

        return $this;
    }
    public function __toString()
    {
        return $this->commandeid;
    }




}
