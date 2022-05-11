<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ReponseRepository;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Reponse
 *
 * @ORM\Table(name="reponse", indexes={@ORM\Index(name="fkreponse", columns={"reclamationid"})})
 * @ORM\Entity(repositoryClass=ReponseRepository::class)
 */
class Reponse
{
    /**
     * @var int
     *
     * @ORM\Column(name="reponseid", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $reponseid;

    /**
     * @var string
     *
     * @ORM\Column(name="reponse", type="text", length=65535, nullable=false)
     */
    private $reponse;

    /**
     * @var \Reclamation
     *
     * @ORM\ManyToOne(targetEntity="Reclamation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="reclamationid", referencedColumnName="reclamationid")
     * })
     */
    private $reclamationid;

    public function getReponseid()
    {
        return $this->reponseid;
    }

    public function getReponse()
    {
        return $this->reponse;
    }

    public function setReponse($reponse): self
    {
        $this->reponse = $reponse;

        return $this;
    }

    public function getReclamationid()
    {
        return $this->reclamationid;
    }

    public function setReclamationid( $reclamationid): self
    {
        $this->reclamationid = $reclamationid;

        return $this;
    }


}
