<?php

namespace App\Entity;

use App\Repository\EspecialidadRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EspecialidadRepository::class)]
class Especialidad
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    /**
     * @var Collection<int, Medicos>
     */
    #[ORM\ManyToMany(targetEntity: Medicos::class, mappedBy: 'especialidad')]
    private Collection $medicos;

    /**
     * @var Collection<int, Cita>
     */
    #[ORM\OneToMany(targetEntity: Cita::class, mappedBy: 'especialidad')]
    private Collection $citas;

    public function __construct()
    {
        $this->medicos = new ArrayCollection();
        $this->citas = new ArrayCollection();
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
     * @return Collection<int, Medicos>
     */
    public function getMedicos(): Collection
    {
        return $this->medicos;
    }

    public function addMedico(Medicos $medico): static
    {
        if (!$this->medicos->contains($medico)) {
            $this->medicos->add($medico);
            $medico->addEspecialidad($this);
        }

        return $this;
    }

    public function removeMedico(Medicos $medico): static
    {
        if ($this->medicos->removeElement($medico)) {
            $medico->removeEspecialidad($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Cita>
     */
    public function getCitas(): Collection
    {
        return $this->citas;
    }

    public function addCita(Cita $cita): static
    {
        if (!$this->citas->contains($cita)) {
            $this->citas->add($cita);
            $cita->setEspecialidad($this);
        }

        return $this;
    }

    public function removeCita(Cita $cita): static
    {
        if ($this->citas->removeElement($cita)) {
            // set the owning side to null (unless already changed)
            if ($cita->getEspecialidad() === $this) {
                $cita->setEspecialidad(null);
            }
        }

        return $this;
    }
}
