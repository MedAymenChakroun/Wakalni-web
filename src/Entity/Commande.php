<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
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
     * @Assert\NotBlank(message="Date de creation cannot be blank.")
     */
    private $datecreation;

    /**
     * @var \DateTime|null
     * @Assert\NotBlank(message="Date d'expedition cannot be blank.")
     * 
     * @ORM\Column(name="dateexpedition", type="datetime", nullable=true)
     */
    private $dateexpedition;

    /**
     * @var \DateTime|null
     *  @Assert\NotBlank(message="Date d'arrivée cannot be blank.")
     * @ORM\Column(name="datearrivee", type="datetime", nullable=true)
     */
    private $datearrivee;
    
    /**
     * @var int
     *
     * @ORM\Column(name="total", type="integer", nullable=false)
     * @Assert\GreaterThan(value=0, message="Total must be greater than 0.")
     * @Assert\NotBlank(message="Total cannot be blank.")
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
    public $clientid;

   


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
        return (string) $this->commandeid;
    }

    /**
     * @Assert\Callback(callback="validateDates")
     */
    public function validateDates(ExecutionContextInterface $context)
    {
        // Ensure that dateexpedition is not greater than datearrivee
        if ($this->dateexpedition !== null && $this->datearrivee !== null && $this->dateexpedition > $this->datearrivee) {
            $context->buildViolation('Date d\'expedition cannot be greater than Date d\'arrivée.')
                ->atPath('dateexpedition')
                ->addViolation();
        }

        // Ensure that dateexpedition and datearrivee are not inferior to datecreation
        if ($this->dateexpedition !== null && $this->dateexpedition < $this->datecreation) {
            $context->buildViolation('Date d\'expedition must not be earlier than Date de creation.')
                ->atPath('dateexpedition')
                ->addViolation();
        }

        if ($this->datearrivee !== null && $this->datearrivee < $this->datecreation) {
            $context->buildViolation('Date d\'arrivée must not be earlier than Date de creation.')
                ->atPath('datearrivee')
                ->addViolation();
        }
    }
}
