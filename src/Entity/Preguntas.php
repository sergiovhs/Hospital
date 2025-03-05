<?php

namespace App\Entity;

use App\Repository\PreguntasRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PreguntasRepository::class)]
class Preguntas
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column]
    private ?int $orden = null;

    #[ORM\ManyToOne(inversedBy: 'preguntas')]
    private ?encuestas $encuesta = null;

    /**
     * @var Collection<int, Respuestas>
     */
    #[ORM\OneToMany(targetEntity: Respuestas::class, mappedBy: 'pregunta')]
    private Collection $respuestas;

    public function __construct()
    {
        $this->respuestas = new ArrayCollection();
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

    public function getEncuesta(): ?encuestas
    {
        return $this->encuesta;
    }

    public function setEncuesta(?encuestas $encuesta): static
    {
        $this->encuesta = $encuesta;

        return $this;
    }

    /**
     * @return Collection<int, Respuestas>
     */
    public function getRespuestas(): Collection
    {
        return $this->respuestas;
    }

    public function addRespuesta(Respuestas $respuesta): static
    {
        if (!$this->respuestas->contains($respuesta)) {
            $this->respuestas->add($respuesta);
            $respuesta->setPregunta($this);
        }

        return $this;
    }

    public function removeRespuesta(Respuestas $respuesta): static
    {
        if ($this->respuestas->removeElement($respuesta)) {
            // set the owning side to null (unless already changed)
            if ($respuesta->getPregunta() === $this) {
                $respuesta->setPregunta(null);
            }
        }

        return $this;
    }
}
