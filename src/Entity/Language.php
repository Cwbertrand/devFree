<?php

namespace App\Entity;

use App\Repository\LanguageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LanguageRepository::class)]
class Language
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $native_lang = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $other_lang = null;

    #[ORM\OneToMany(mappedBy: 'language', targetEntity: Developer::class)]
    private Collection $developers;

    public function __construct()
    {
        $this->developers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNativeLang(): ?string
    {
        return $this->native_lang;
    }

    public function setNativeLang(string $native_lang): self
    {
        $this->native_lang = $native_lang;

        return $this;
    }

    public function getOtherLang(): ?string
    {
        return $this->other_lang;
    }

    public function setOtherLang(?string $other_lang): self
    {
        $this->other_lang = $other_lang;

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
            $developer->setLanguage($this);
        }

        return $this;
    }

    public function removeDeveloper(Developer $developer): self
    {
        if ($this->developers->removeElement($developer)) {
            // set the owning side to null (unless already changed)
            if ($developer->getLanguage() === $this) {
                $developer->setLanguage(null);
            }
        }

        return $this;
    }
}
