<?php

namespace App\Entity;

use App\Repository\MedicosRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MedicosRepository::class)]
class Medicos
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    /**
     * @var Collection<int, especialidad>
     */
    #[ORM\ManyToMany(targetEntity: especialidad::class, inversedBy: 'medicos')]
    private Collection $especialidad;

    public function __construct()
    {
        $this->especialidad = new ArrayCollection();
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

    /**
     * @return Collection<int, especialidad>
     */
    public function getEspecialidad(): Collection
    {
        return $this->especialidad;
    }

    public function addEspecialidad(especialidad $especialidad): static
    {
        if (!$this->especialidad->contains($especialidad)) {
            $this->especialidad->add($especialidad);
        }

        return $this;
    }

    public function removeEspecialidad(especialidad $especialidad): static
    {
        $this->especialidad->removeElement($especialidad);

        return $this;
    }
}
