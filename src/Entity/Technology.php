<?php

namespace App\Entity;

use App\Repository\TechnologyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TechnologyRepository::class)]
class Technology
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $tech_name = null;

    #[ORM\ManyToMany(targetEntity: Developer::class, mappedBy: 'technology')]
    private Collection $developers;

    #[ORM\ManyToMany(targetEntity: TechCategory::class, inversedBy: 'technologies')]
    private Collection $tech_category;

    public function __construct()
    {
        $this->developers = new ArrayCollection();
        $this->tech_category = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTechName(): ?string
    {
        return $this->tech_name;
    }

    public function setTechName(string $tech_name): self
    {
        $this->tech_name = $tech_name;

        return $this;
    }

    /**
     * @return Collection<int, Developer>
     */
    public function getDevelopers(): Collection
    {
        return $this->developers;
    }

    public function addDeveloper(Developer $developer): self
    {
        if (!$this->developers->contains($developer)) {
            $this->developers->add($developer);
            $developer->addTechnology($this);
        }

        return $this;
    }

    public function removeDeveloper(Developer $developer): self
    {
        if ($this->developers->removeElement($developer)) {
            $developer->removeTechnology($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, TechCategory>
     */
    public function getTechCategory(): Collection
    {
        return $this->tech_category;
    }

    public function addTechCategory(TechCategory $techCategory): self
    {
        if (!$this->tech_category->contains($techCategory)) {
            $this->tech_category->add($techCategory);
        }

        return $this;
    }

    public function removeTechCategory(TechCategory $techCategory): self
    {
        $this->tech_category->removeElement($techCategory);

        return $this;
    }
}
