<?php

namespace App\Entity;

use App\Repository\StudentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StudentRepository::class)
 */
class Student
{


    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=255)
     */
    private $nsc;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\ManyToOne(targetEntity=Classroom::class, inversedBy="students")
     * @ORM\JoinColumn(nullable=false)
     */
    private $classroom;


    /**
     * @ORM\ManyToMany(targetEntity=Club::class, inversedBy="students")
     *  @ORM\JoinTable(name="students_clubs",
     *      joinColumns={@ORM\JoinColumn(name="student_id", referencedColumnName="nsc")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="club_id", referencedColumnName="ref")}
     *      )
     */
    private $clubs;

    public function __construct()
    {
        $this->clubs = new ArrayCollection();
    }

   public function getNsc(): ?string
    {
        return $this->nsc;
    }

    public function setNsc(string $nsc): self
    {
        $this->nsc = $nsc;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getClassroom(): ?Classroom
    {
        return $this->classroom;
    }

    public function setClassroom(?Classroom $classroom): self
    {
        $this->classroom = $classroom;

        return $this;
    }

    public function __toString()
    {
        return(string)$this->getEmail();
    }

    /**
     * @return Collection|Club[]
     */
    public function getClubs(): Collection
    {
        return $this->clubs;
    }

    public function addClub(Club $club): self
    {
        if (!$this->clubs->contains($club)) {
            $this->clubs[] = $club;
            $club->addStudent($this);
        }

        return $this;
    }

    public function removeClub(Club $club): self
    {
        if ($this->clubs->removeElement($club)) {
            $club->removeStudent($this);
        }

        return $this;
    }
}
