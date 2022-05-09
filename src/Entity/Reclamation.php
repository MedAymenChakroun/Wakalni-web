<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ReclamationRepository;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Reclamation
 *
 * @ORM\Table(name="reclamation", indexes={@ORM\Index(name="fkclientrec", columns={"clientid"}), @ORM\Index(name="fkcommanderec", columns={"commandeid"})})
 * @ORM\Entity(repositoryClass=ReclamationRepository::class)
 * @Groups("post:read")
 */
class Reclamation
{
    /**
     * @var int
     * @Groups("post:read")
     * @ORM\Column(name="reclamationid", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $reclamationid;

    /**
     * @var string
     * @Groups("post:read")
     * @Assert\NotBlank(message=" sujet doit etre non vide")
    @Assert\Regex(
     *     pattern     = "/^[a-z]+$/i",
     *     htmlPattern = "[a-zA-Z]+",
     *     message="Le sujet doit être alphabétique"
     * )
     *
     * @ORM\Column(name="sujet", type="string", length=30, nullable=false)
     */
    private $sujet;

    /**
     * @var string
     * @Assert\NotBlank(message=" contenu doit etre non vide")
     * @Groups("post:read")
     *
     * @ORM\Column(name="contenu", type="text", length=65535, nullable=false)
     */
    private $contenu;

    /**
     * @var string|null
     * @Groups("post:read")
     * @ORM\Column(name="etat", type="string", length=30, nullable=true, options={"default"="encoure"})
     */
    private $etat = 'encoure';

    /**
     * @var \Commande
     * @Groups("post:read")
     * @ORM\ManyToOne(targetEntity="Commande")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="commandeid", referencedColumnName="commandeid")
     * })
     */
    private $commandeid;

    /**
     * @var \Utilisateur
     * @Groups("post:read")
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="clientid", referencedColumnName="id")
     * })
     */
    private $clientid;

    public function getReclamationid()
    {
        return $this->reclamationid;
    }

    public function getSujet()
    {
        return $this->sujet;
    }

    public function setSujet( $sujet): self
    {
        $this->sujet = $sujet;

        return $this;
    }

    public function getContenu()
    {
        return $this->contenu;
    }

    public function setContenu( $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getEtat()
    {
        return $this->etat;
    }

    public function setEtat( $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getCommandeid()
    {
        return $this->commandeid;
    }

    public function setCommandeid( $commandeid): self
    {
        $this->commandeid = $commandeid;

        return $this;
    }

    public function getClientid()
    {
        return $this->clientid;
    }

    public function setClientid($clientid): self
    {
        $this->clientid = $clientid;

        return $this;
    }
    public function sendEmail(MailerInterface $mailer)
    {
        $email = (new Email())
            ->from('wakalni801@gmail.com')
            ->to('lacht06@gmail.com')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Time for Symfony Mailer!')
            ->text('Sending emails is fun again!')
        ;


        $mailer->send($email);

        // ...
    }

}
