<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NotaRepository")
 */
class Nota
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $calificacion;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Estudiante", inversedBy="notas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $estudiante;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Asignatura", inversedBy="notas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $asignatura;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCalificacion(): ?float
    {
        return $this->calificacion;
    }

    public function setCalificacion(float $calificacion): self
    {
        $this->calificacion = $calificacion;

        return $this;
    }

    public function getEstudiante(): ?Estudiante
    {
        return $this->estudiante;
    }

    public function setEstudiante(?Estudiante $estudiante): self
    {
        $this->estudiante = $estudiante;

        return $this;
    }

    public function getAsignatura(): ?Asignatura
    {
        return $this->asignatura;
    }

    public function setAsignatura(?Asignatura $asignatura): self
    {
        $this->asignatura = $asignatura;

        return $this;
    }
}
