<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * Organisation
 *
 * @ORM\Table(name="organisation", indexes={@ORM\Index(name="fkorganisation", columns={"leftoverid"})})
 * @ORM\Entity
 */
class Organisation
{
    /**
     * @var int
     *
     * @ORM\Column(name="organisationid", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Groups("api:organisation")
     */
    private $organisationid;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=30, nullable=false)
     * @Assert\NotBlank(message="Must be filled")
     * @Assert\Regex(
     *     pattern     = "/^[a-z]+$/i",
     *     htmlPattern = "^[a-zA-Z]+$",
     *     message="{{ value }} doit etre String "
     * )
     * @Groups("api:organisation")
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=30, nullable=false)
     * @Assert\NotBlank(message="Must be filled")
     * @Assert\Regex(
     *     pattern     = "/^[a-z]+$/i",
     *     htmlPattern = "^[a-zA-Z]+$",
     *     message="{{ value }} doit etre String "
     * )
     * @Groups("api:organisation")
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=30, nullable=false)
     *   @Assert\NotBlank(message="Must be filled")
     *   @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email."
     * )
     * @Groups("api:organisation")
     */
    private $email;

    /**
     * @var int
     *
     * @ORM\Column(name="numero", type="integer", nullable=false)
     *  @Assert\NotBlank(message="Must be filled")
     *        @Assert\Positive(message="Must be positive")

     *
     * )
     * @Groups("api:organisation")
     */
    private $numero;

    /**
     * @var \Leftovers
     *
     * @ORM\ManyToOne(targetEntity="Leftovers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="leftoverid", referencedColumnName="leftoverid")

     * })
     *  @Assert\NotBlank(message="Must be filled")
     */
    private $leftoverid;

    public function getOrganisationid(): ?int
    {
        return $this->organisationid;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getNumero(): ?int
    {
        return $this->numero;
    }

    public function setNumero(int $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getLeftoverid(): ?Leftovers
    {
        return $this->leftoverid;
    }

    public function setLeftoverid(?Leftovers $leftoverid): self
    {
        $this->leftoverid = $leftoverid;

        return $this;
    }


}
