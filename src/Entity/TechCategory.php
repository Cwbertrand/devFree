<?php

namespace App\Entity;

use App\Repository\TechCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TechCategoryRepository::class)]
class TechCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    private ?string $tech_cat_name = null;

    #[ORM\ManyToMany(targetEntity: Technology::class, mappedBy: 'tech_category')]
    private Collection $technologies;

    #[ORM\ManyToOne(inversedBy: 'techCategories')]
    private ?GeneralCategory $gen_cat = null;

    public function __construct()
    {
        $this->technologies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTechCatName(): ?string
    {
        return $this->tech_cat_name;
    }

    public function __toString()
    {
        return $this->getTechCatName();
    }

    public function setTechCatName(string $tech_cat_name): self
    {
        $this->tech_cat_name = $tech_cat_name;

        return $this;
    }

    /**
     * @return Collection<int, Technology>
     */
    public function getTechnologies(): Collection
    {
        return $this->technologies;
    }

    public function addTechnology(Technology $technology): self
    {
        if (!$this->technologies->contains($technology)) {
            $this->technologies->add($technology);
            $technology->addTechCategory($this);
        }

        return $this;
    }

    public function removeTechnology(Technology $technology): self
    {
        if ($this->technologies->removeElement($technology)) {
            $technology->removeTechCategory($this);
        }

        return $this;
    }

    public function getGenCat(): ?GeneralCategory
    {
        return $this->gen_cat;
    }

    public function setGenCat(?GeneralCategory $gen_cat): self
    {
        $this->gen_cat = $gen_cat;

        return $this;
    }
}
