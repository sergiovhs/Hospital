<?php

namespace App\Entity;

use App\Repository\BolsaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BolsaRepository::class)]
class Bolsa
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $fecha_inicio = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $fecha_fin = null;

    /**
     * @var Collection<int, Demandante>
     */
    #[ORM\OneToMany(targetEntity: Demandante::class, mappedBy: 'bolsa')]
    private Collection $demandantes;

    public function __construct()
    {
        $this->demandantes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getFechaInicio(): ?\DateTimeInterface
    {
        return $this->fecha_inicio;
    }

    public function setFechaInicio(\DateTimeInterface $fecha_inicio): static
    {
        $this->fecha_inicio = $fecha_inicio;

        return $this;
    }

    public function getFechaFin(): ?\DateTimeInterface
    {
        return $this->fecha_fin;
    }

    public function setFechaFin(\DateTimeInterface $fecha_fin): static
    {
        $this->fecha_fin = $fecha_fin;

        return $this;
    }

    /**
     * @return Collection<int, Demandante>
     */
    public function getDemandantes(): Collection
    {
        return $this->demandantes;
    }

    public function addDemandante(Demandante $demandante): static
    {
        if (!$this->demandantes->contains($demandante)) {
            $this->demandantes->add($demandante);
            $demandante->setBolsa($this);
        }

        return $this;
    }

    public function removeDemandante(Demandante $demandante): static
    {
        if ($this->demandantes->removeElement($demandante)) {
            // set the owning side to null (unless already changed)
            if ($demandante->getBolsa() === $this) {
                $demandante->setBolsa(null);
            }
        }

        return $this;
    }
}
