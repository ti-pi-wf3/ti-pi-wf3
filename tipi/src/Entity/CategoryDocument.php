<?php

namespace App\Entity;

use App\Repository\CategoryDocumentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryDocumentRepository::class)
 */
class CategoryDocument
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titleCategoryDoc;

    /**
     * @ORM\OneToMany(targetEntity=Documents::class, mappedBy="categoryDocument")
     */
    private $documents;

    /**
     * @ORM\ManyToOne(targetEntity=tribe::class, inversedBy="categoryDocuments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tribe;

    public function __construct()
    {
        $this->documents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitleCategoryDoc(): ?string
    {
        return $this->titleCategoryDoc;
    }

    public function setTitleCategoryDoc(string $titleCategoryDoc): self
    {
        $this->titleCategoryDoc = $titleCategoryDoc;

        return $this;
    }

    /**
     * @return Collection|Documents[]
     */
    public function getDocuments(): Collection
    {
        return $this->documents;
    }

    public function addDocument(Documents $document): self
    {
        if (!$this->documents->contains($document)) {
            $this->documents[] = $document;
            $document->setCategoryDocument($this);
        }

        return $this;
    }

    public function removeDocument(Documents $document): self
    {
        if ($this->documents->removeElement($document)) {
            // set the owning side to null (unless already changed)
            if ($document->getCategoryDocument() === $this) {
                $document->setCategoryDocument(null);
            }
        }

        return $this;
    }

    public function getTribe(): ?tribe
    {
        return $this->tribe;
    }

    public function setTribe(?tribe $tribe): self
    {
        $this->tribe = $tribe;

        return $this;
    }
}
