<?php

namespace App\Entity;

use App\Repository\ResultadosRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ResultadosRepository::class)]
class Resultados
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'resultados')]
    private ?Respuestas $respuesta = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRespuesta(): ?Respuestas
    {
        return $this->respuesta;
    }

    public function setRespuesta(?Respuestas $respuesta): static
    {
        $this->respuesta = $respuesta;

        return $this;
    }
}
