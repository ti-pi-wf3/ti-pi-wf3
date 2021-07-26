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
    private $titleCategoryDocument;

    /**
     * @ORM\OneToMany(targetEntity=Documents::class, mappedBy="titleCategoryDocument")
     */
    private $documents;

    public function __construct()
    {
        $this->documents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitleCategoryDocument(): ?string
    {
        return $this->titleCategoryDocument;
    }

    public function setTitleCategoryDocument(string $titleCategoryDocument): self
    {
        $this->titleCategoryDocument = $titleCategoryDocument;

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
            $document->setTitleCategoryDocument($this);
        }

        return $this;
    }

    public function removeDocument(Documents $document): self
    {
        if ($this->documents->removeElement($document)) {
            // set the owning side to null (unless already changed)
            if ($document->getTitleCategoryDocument() === $this) {
                $document->setTitleCategoryDocument(null);
            }
        }

        return $this;
    }
}
