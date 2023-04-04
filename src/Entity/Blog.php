<?php

namespace App\Entity;

use App\Repository\BlogRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BlogRepository::class)]
class Blog
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Introduction = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Definition = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Signes_cliniques = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Examens = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $complementaires = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Diagnostic = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Pronostic_Evaluation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Prise_en_charge = null;

    #[ORM\Column(length: 255, nullable: true)]
    public ?string $Points_cles = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Diagnostic_difficile = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cat = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $date_article = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $id_user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIntroduction(): ?string
    {
        return $this->Introduction;
    }

    public function setIntroduction(?string $Introduction): self
    {
        $this->Introduction = $Introduction;

        return $this;
    }

    public function getDefinition(): ?string
    {
        return $this->Definition;
    }

    public function setDefinition(?string $Definition): self
    {
        $this->Definition = $Definition;

        return $this;
    }

    public function getSignesCliniques(): ?string
    {
        return $this->Signes_cliniques;
    }

    public function setSignesCliniques(?string $Signes_cliniques): self
    {
        $this->Signes_cliniques = $Signes_cliniques;

        return $this;
    }

    public function getExamens(): ?string
    {
        return $this->Examens;
    }

    public function setExamens(?string $Examens): self
    {
        $this->Examens = $Examens;

        return $this;
    }

    public function getComplementaires(): ?string
    {
        return $this->complementaires;
    }

    public function setComplementaires(?string $complementaires): self
    {
        $this->complementaires = $complementaires;

        return $this;
    }

    public function getDiagnostic(): ?string
    {
        return $this->Diagnostic;
    }

    public function setDiagnostic(?string $Diagnostic): self
    {
        $this->Diagnostic = $Diagnostic;

        return $this;
    }

    public function getPronosticEvaluation(): ?string
    {
        return $this->Pronostic_Evaluation;
    }

    public function setPronosticEvaluation(?string $Pronostic_Evaluation): self
    {
        $this->Pronostic_Evaluation = $Pronostic_Evaluation;

        return $this;
    }

    public function getPriseEnCharge(): ?string
    {
        return $this->Prise_en_charge;
    }

    public function setPriseEnCharge(?string $Prise_en_charge): self
    {
        $this->Prise_en_charge = $Prise_en_charge;

        return $this;
    }

    public function getPointsCles(): ?string
    {
        return $this->Points_cles;
    }

    public function setPointsCles(?string $Points_cles): self
    {
        $this->Points_cles = $Points_cles;

        return $this;
    }

    public function getDiagnosticDifficile(): ?string
    {
        return $this->Diagnostic_difficile;
    }

    public function setDiagnosticDifficile(?string $Diagnostic_difficile): self
    {
        $this->Diagnostic_difficile = $Diagnostic_difficile;

        return $this;
    }

    public function getCat(): ?string
    {
        return $this->cat;
    }

    public function setCat(?string $cat): self
    {
        $this->cat = $cat;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getDateArticle(): ?string
    {
        return $this->date_article;
    }

    public function setDateArticle(?string $date_article): self
    {
        $this->date_article = $date_article;

        return $this;
    }

    public function getIdUser(): ?string
    {
        return $this->id_user;
    }

    public function setIdUser(?string $id_user): self
    {
        $this->id_user = $id_user;

        return $this;
    }
}
