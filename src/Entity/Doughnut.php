<?php

/** Namespace */
namespace App\Entity;

/** Usages */
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * Class Doughnut
 * @ORM\Table(name="doughnut")
 * @ORM\Entity(repositoryClass="App\Repository\DoughnutRepository")
 * @UniqueEntity("reference")
 * @package App\Entity
 */
class Doughnut
{
    use TimestampableTrait;

    /**
     * @var int
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="reference", type="string", nullable=false, unique=true)
     */
    private $reference;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", nullable=false)
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(name="flavour", type="string", nullable=false)
     */
    private $flavour;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Doughnut
     */
    public function setId(int $id): Doughnut
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getReference(): string
    {
        return $this->reference;
    }

    /**
     * @param string $reference
     * @return Doughnut
     */
    public function setReference(string $reference): Doughnut
    {
        $this->reference = $reference;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Doughnut
     */
    public function setName(string $name): Doughnut
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getFlavour(): string
    {
        return $this->flavour;
    }

    /**
     * @param string $flavour
     * @return Doughnut
     */
    public function setFlavour(string $flavour): Doughnut
    {
        $this->flavour = $flavour;
        return $this;
    }
}