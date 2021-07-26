<?php

namespace App\Entity;

use App\Repository\DocumentsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DocumentsRepository::class)
 */
class Documents
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="documents")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=CategoryDocument::class, inversedBy="documents")
     * @ORM\JoinColumn(nullable=false)
     */
    private $titleCategoryDocument;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fileTitle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titleDocument;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=Files::class, mappedBy="document")
     */
    private $files;

    public function __construct()
    {
        $this->files = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getTitleCategoryDocument(): ?CategoryDocument
    {
        return $this->titleCategoryDocument;
    }

    public function setTitleCategoryDocument(?CategoryDocument $titleCategoryDocument): self
    {
        $this->titleCategoryDocument = $titleCategoryDocument;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getFileTitle(): ?string
    {
        return $this->fileTitle;
    }

    public function setFileTitle(string $fileTitle): self
    {
        $this->fileTitle = $fileTitle;

        return $this;
    }

    public function getTitleDocument(): ?string
    {
        return $this->titleDocument;
    }

    public function setTitleDocument(string $titleDocument): self
    {
        $this->titleDocument = $titleDocument;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Files[]
     */
    public function getFiles(): Collection
    {
        return $this->files;
    }

    public function addFile(Files $file): self
    {
        if (!$this->files->contains($file)) {
            $this->files[] = $file;
            $file->setDocument($this);
        }

        return $this;
    }

    public function removeFile(Files $file): self
    {
        if ($this->files->removeElement($file)) {
            // set the owning side to null (unless already changed)
            if ($file->getDocument() === $this) {
                $file->setDocument(null);
            }
        }

        return $this;
    }
}
