<?php

namespace App\Entity;

use App\Repository\ServicioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServicioRepository::class)]
class Servicio
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    /**
     * @var Collection<int, texto>
     */
    #[ORM\OneToMany(targetEntity: Texto::class, mappedBy: 'servicio')]
    private Collection $texto;

    public function __construct()
    {
        $this->texto = new ArrayCollection();
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
     * @return Collection<int, texto>
     */
    public function getTexto(): Collection
    {
        return $this->texto;
    }

    public function addTexto(texto $texto): static
    {
        if (!$this->texto->contains($texto)) {
            $this->texto->add($texto);
            $texto->setServicio($this);
        }

        return $this;
    }

    public function removeTexto(texto $texto): static
    {
        if ($this->texto->removeElement($texto)) {
            // set the owning side to null (unless already changed)
            if ($texto->getServicio() === $this) {
                $texto->setServicio(null);
            }
        }

        return $this;
    }
}
