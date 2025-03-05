<?php

namespace App\Entity;

use App\Repository\RespuestasRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RespuestasRepository::class)]
class Respuestas
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column]
    private ?int $orden = null;

    #[ORM\ManyToOne(inversedBy: 'respuestas')]
    private ?Preguntas $pregunta = null;

    /**
     * @var Collection<int, Resultados>
     */
    #[ORM\OneToMany(targetEntity: Resultados::class, mappedBy: 'respuesta')]
    private Collection $resultados;

    public function __construct()
    {
        $this->resultados = new ArrayCollection();
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

    public function getOrden(): ?int
    {
        return $this->orden;
    }

    public function setOrden(int $orden): static
    {
        $this->orden = $orden;

        return $this;
    }

    public function getPregunta(): ?Preguntas
    {
        return $this->pregunta;
    }

    public function setPregunta(?Preguntas $pregunta): static
    {
        $this->pregunta = $pregunta;

        return $this;
    }

    /**
     * @return Collection<int, Resultados>
     */
    public function getResultados(): Collection
    {
        return $this->resultados;
    }

    public function addResultado(Resultados $resultado): static
    {
        if (!$this->resultados->contains($resultado)) {
            $this->resultados->add($resultado);
            $resultado->setRespuesta($this);
        }

        return $this;
    }

    public function removeResultado(Resultados $resultado): static
    {
        if ($this->resultados->removeElement($resultado)) {
            // set the owning side to null (unless already changed)
            if ($resultado->getRespuesta() === $this) {
                $resultado->setRespuesta(null);
            }
        }

        return $this;
    }
}
