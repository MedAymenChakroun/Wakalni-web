<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commande
 *
 * @ORM\Table(name="commande", indexes={@ORM\Index(name="fkclient", columns={"clientid"}),@ORM\Index(name="fkrc", columns={"rcid"})})
 * @ORM\Entity
 */
class Commande
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
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
     * @var int
     *
     * @ORM\Column(name="total", type="integer", nullable=false)
     */
    private $total;




    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="clientid", referencedColumnName="id")
     * })
     */
    private $clientid;

   


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


    public function getTotal(): ?int
    {
        return $this->total;
    }

    public function setTotal(?int $total): self
    {
        $this->total = $total;

        return $this;
    }

    

    public function getClientid(): ?User
    {
        return $this->clientid;
    }

    public function setClientid(?User $clientid): self
    {
        $this->clientid = $clientid;

        return $this;
    }

    

   
    public function __toString()
    {
        return $this->commandeid;
    }




}
