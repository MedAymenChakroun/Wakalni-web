<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Leftovers
 *
 * @ORM\Table(name="leftovers", indexes={@ORM\Index(name="fkleftover", columns={"crid"})})
 * @ORM\Entity
 */
class Leftovers
{
    /**
     * @var int
     *
     * @ORM\Column(name="leftoverid", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $leftoverid;

    /**
     * @var string
     *
     * @ORM\Column(name="sujet", type="string", length=30, nullable=false)
     */
    private $sujet;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=30, nullable=false)
     */
    private $type;

    /**
     * @var int
     *
     * @ORM\Column(name="quantite", type="integer", nullable=false)
     */
    private $quantite;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateexpiration", type="datetime", nullable=false)
     */
    private $dateexpiration;

    /**
     * @var \Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="crid", referencedColumnName="id")
     * })
     */
    private $crid;


}
