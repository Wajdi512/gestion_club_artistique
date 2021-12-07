<?php

namespace App\Entity;

use App\Repository\SeanceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SeanceRepository::class)
 */
class Seance
{

    /**
     * @ORM\Column(type="datetime")
     */
    private $heureDebut;

    /**
     * @ORM\Column(type="datetime")
     */
    private $heureFin;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity=Coach::class, inversedBy="seances")
     * @ORM\JoinColumn(name="coach_id", referencedColumnName="codeCo", nullable=false)
     */
    private $coach;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity=Activite::class, inversedBy="seances")
     * @ORM\JoinColumn(name="activite_id", referencedColumnName="codeAct", nullable=false)
     */
    private $activite;


    /**
     * Seance constructor.
     * @param $heureDebut
     * @param $heureFin
     * @param $coach
     * @param $activite
     */
    public function __construct($heureDebut, $heureFin, $coach, $activite)
    {
        $this->heureDebut = $heureDebut;
        $this->heureFin = $heureFin;
        $this->coach = $coach;
        $this->activite = $activite;
    }


    public function getHeureDebut(): ?\DateTimeInterface
    {
        return $this->heureDebut;
    }

    public function setHeureDebut(\DateTimeInterface $heureDebut): self
    {
        $this->heureDebut = $heureDebut;

        return $this;
    }

    public function getHeureFin(): ?\DateTimeInterface
    {
        return $this->heureFin;
    }

    public function setHeureFin(\DateTimeInterface $heureFin): self
    {
        $this->heureFin = $heureFin;

        return $this;
    }

    public function getCoach(): ?Coach
    {
        return $this->coach;
    }

    public function setCoach(?Coach $coach): self
    {
        $this->coach = $coach;

        return $this;
    }

    public function getActivite(): ?Activite
    {
        return $this->activite;
    }

    public function setActivite(?Activite $activite): self
    {
        $this->activite = $activite;

        return $this;
    }
}
