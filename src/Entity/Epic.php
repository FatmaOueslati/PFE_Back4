<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;


/**
 * @ApiResource()
 * @ApiFilter(SearchFilter::class, properties={"name": "partial" , "description": "partial"})
 * @ORM\Entity(repositoryClass="App\Repository\EpicRepository")
 */
class Epic
{

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $somme_complex;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $duree;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Project", inversedBy="epics")
     * @JoinColumn(name="project_id", referencedColumnName="id")
     */
    protected $projs;


    /**
     *
     * @ORM\OneToMany(targetEntity="App\Entity\UserStory", mappedBy="epic")
     * @JoinColumn(name="story_id", referencedColumnName="id")
     */
    protected $stories;

    public function __construct()
    {
        $this->stories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }



    public function getDuree(): ?string
    {
        return $this->duree;
    }

    public function setDuree(?string $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSommeComplex()
    {
        return $this->somme_complex;
    }

    /**
     * @param mixed $somme_complex
     */
    public function setSommeComplex($somme_complex): void
    {
        $this->somme_complex = $somme_complex;
    }

    public function getProjs(): ?Project
    {
        return $this->projs;
    }

    public function setProjs(?Project $projs): self
    {
        $this->projs = $projs;

        return $this;
    }

    /**
     * @return Collection|UserStory[]
     */
    public function getStories(): Collection
    {
        return $this->stories;
    }

    public function addStory(UserStory $story): self
    {
        if (!$this->stories->contains($story)) {
            $this->stories[] = $story;
            $story->setEpic($this);
        }

        return $this;
    }

    public function removeStory(UserStory $story): self
    {
        if ($this->stories->contains($story)) {
            $this->stories->removeElement($story);
            // set the owning side to null (unless already changed)
            if ($story->getEpic() === $this) {
                $story->setEpic(null);
            }
        }

        return $this;
    }
}
