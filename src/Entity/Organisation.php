<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     */
    private $organisationid;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=30, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=30, nullable=false)
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=30, nullable=false)
     */
    private $email;

    /**
     * @var int
     *
     * @ORM\Column(name="numero", type="integer", nullable=false)
     */
    private $numero;

    /**
     * @var \Leftovers
     *
     * @ORM\ManyToOne(targetEntity="Leftovers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="leftoverid", referencedColumnName="leftoverid")
     * })
     */
    private $leftoverid;


}
