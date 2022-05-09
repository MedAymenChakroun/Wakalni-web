<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommandeRepository;


/**
 * Commande
 *
 * @ORM\Table(name="commande", indexes={@ORM\Index(name="fkrc", columns={"rcid"}), @ORM\Index(name="fkpanier", columns={"panierid"}), @ORM\Index(name="fkclient", columns={"clientid"}), @ORM\Index(name="fklivreur", columns={"livreurid"})})
 * @ORM\Entity(repositoryClass=CommandeRepository::class)
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
     * @var \DateTime
     *
     * @ORM\Column(name="datecreation", type="datetime", nullable=false)
     */
    private $datecreation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateexpedition", type="datetime", nullable=false)
     */
    private $dateexpedition;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datearrivee", type="datetime", nullable=false)
     */
    private $datearrivee;

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

    public function getCommandeid()
    {
        return $this->commandeid;
    }

    public function setCommandeid( $commandeid): void
    {
        $this->commandeid = $commandeid;
    }

    public function getDatecreation()
    {
        return $this->datecreation;
    }

    public function setDatecreation( $datecreation): void
    {
        $this->datecreation = $datecreation;
    }

    public function getDateexpedition()
    {
        return $this->dateexpedition;
    }

    public function setDateexpedition( $dateexpedition): void
    {
        $this->dateexpedition = $dateexpedition;
    }

    public function getDatearrivee()
    {
        return $this->datearrivee;
    }

    public function setDatearrivee( $datearrivee): void
    {
        $this->datearrivee = $datearrivee;
    }

    public function getLivreurid()
    {
        return $this->livreurid;
    }

    public function setLivreurid( $livreurid): void
    {
        $this->livreurid = $livreurid;
    }

    public function getRcid()
    {
        return $this->rcid;
    }

    public function setRcid( $rcid): void
    {
        $this->rcid = $rcid;
    }

    public function getPanierid()
    {
        return $this->panierid;
    }

    public function setPanierid( $panierid): void
    {
        $this->panierid = $panierid;
    }

    public function getClientid()
    {
        return $this->clientid;
    }

    public function setClientid( $clientid): void
    {
        $this->clientid = $clientid;
    }


}
