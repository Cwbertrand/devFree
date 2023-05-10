<?php

namespace App\Entity;

use App\Repository\GeneralCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GeneralCategoryRepository::class)]
class GeneralCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    private ?string $gen_cat_name = null;

    #[ORM\OneToMany(mappedBy: 'gen_cat', targetEntity: TechCategory::class)]
    private Collection $techCategories;

    public function __construct()
    {
        $this->techCategories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGenCatName(): ?string
    {
        return $this->gen_cat_name;
    }

    public function __toString(){
        return $this->getGenCatName();
    }

    public function setGenCatName(string $gen_cat_name): self
    {
        $this->gen_cat_name = $gen_cat_name;

        return $this;
    }

    /**
     * @return Collection<int, TechCategory>
     */
    public function getTechCategories(): Collection
    {
        return $this->techCategories;
    }

    public function addTechCategory(TechCategory $techCategory): self
    {
        if (!$this->techCategories->contains($techCategory)) {
            $this->techCategories->add($techCategory);
            $techCategory->setGenCat($this);
        }

        return $this;
    }

    public function removeTechCategory(TechCategory $techCategory): self
    {
        if ($this->techCategories->removeElement($techCategory)) {
            // set the owning side to null (unless already changed)
            if ($techCategory->getGenCat() === $this) {
                $techCategory->setGenCat(null);
            }
        }

        return $this;
    }
}
