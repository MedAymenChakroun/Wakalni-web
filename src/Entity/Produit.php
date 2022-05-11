<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
/**
 * Produit
 *
 * @ORM\Table(name="produit", indexes={@ORM\Index(name="fkcrp", columns={"crid"})})
 * @ORM\Entity
 * @Vich\Uploadable
 */
class Produit
{
    /**
     * @var int
     *
     * @ORM\Column(name="produitid", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $produitid;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=30, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=30, nullable=false)
     */
    private $type;

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float", precision=10, scale=0, nullable=false)
     */
    private $prix;

     /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="products")
     * 
     * @var File|null
     */
    private $image;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="crid", referencedColumnName="id")
     * })
     */
    private $crid;
     /**
     * @ORM\Column(type="string")
     *
     * @var string|null
     */
    private $imageName;
    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }
    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function getProduitid(): ?int
    {
        return $this->produitid;
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function setImage(?File $image = null): void
    {
        $this->image = $image;

        // if (null !== $imageFile) {
        //     // It is required that at least one field changes if you are using doctrine
        //     // otherwise the event listeners won't be called and the file is lost
        //     $this->updatedAt = new \DateTimeImmutable();
        // }
    }

    public function getImage(): ?File
    {
        return $this->image;
    }

    public function getCrid(): ?User
    {
        return $this->crid;
    }

    public function setCrid(?User $crid): self
    {
        $this->crid = $crid;

        return $this;
    }

    public function __toString()
    {
        return $this->nom;
    }




}
