<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reclamation
 *
 * @ORM\Table(name="reclamation", indexes={@ORM\Index(name="fkcommanderec", columns={"commandeid"}), @ORM\Index(name="fkclientrec", columns={"clientid"})})
 * @ORM\Entity
 */
class Reclamation
{
    /**
     * @var int
     *
     * @ORM\Column(name="reclamationid", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $reclamationid;

    /**
     * @var string
     *
     * @ORM\Column(name="sujet", type="string", length=30, nullable=false)
     */
    private $sujet;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="text", length=65535, nullable=false)
     */
    private $contenu;

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
     * @var \Commande
     *
     * @ORM\ManyToOne(targetEntity="Commande")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="commandeid", referencedColumnName="commandeid")
     * })
     */
    private $commandeid;

    public function getReclamationid(): ?int
    {
        return $this->reclamationid;
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

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

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

    public function getCommandeid(): ?Commande
    {
        return $this->commandeid;
    }

    public function setCommandeid(?Commande $commandeid): self
    {
        $this->commandeid = $commandeid;

        return $this;
    }


}
