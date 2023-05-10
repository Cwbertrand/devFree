<?php

namespace App\Entity;

use App\Repository\ExperienceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExperienceRepository::class)]
class Experience
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $type_experience = null;

    #[ORM\OneToMany(mappedBy: 'experience', targetEntity: Developer::class)]
    private Collection $developers;

    public function __construct()
    {
        $this->developers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeExperience(): ?string
    {
        return $this->type_experience;
    }

    public function setTypeExperience(string $type_experience): self
    {
        $this->type_experience = $type_experience;

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
            $developer->setExperience($this);
        }

        return $this;
    }

    public function removeDeveloper(Developer $developer): self
    {
        if ($this->developers->removeElement($developer)) {
            // set the owning side to null (unless already changed)
            if ($developer->getExperience() === $this) {
                $developer->setExperience(null);
            }
        }

        return $this;
    }
}
