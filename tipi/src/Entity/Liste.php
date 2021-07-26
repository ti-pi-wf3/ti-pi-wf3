<?php

namespace App\Entity;

use App\Repository\ListeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ListeRepository::class)
 */
class Liste
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="listes")
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titleList;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $article;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $valid;

    /**
     * @ORM\ManyToMany(targetEntity=CategoryArticle::class, inversedBy="listes")
     */
    private $titleCategoryArticle;

    public function __construct()
    {
        $this->titleCategoryArticle = new ArrayCollection();
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

    public function getTitleList(): ?string
    {
        return $this->titleList;
    }

    public function setTitleList(string $titleList): self
    {
        $this->titleList = $titleList;

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

    public function getArticle(): ?string
    {
        return $this->article;
    }

    public function setArticle(string $article): self
    {
        $this->article = $article;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getValid(): ?int
    {
        return $this->valid;
    }

    public function setValid(?int $valid): self
    {
        $this->valid = $valid;

        return $this;
    }

    /**
     * @return Collection|CategoryArticle[]
     */
    public function getTitleCategoryArticle(): Collection
    {
        return $this->titleCategoryArticle;
    }

    public function addTitleCategoryArticle(CategoryArticle $titleCategoryArticle): self
    {
        if (!$this->titleCategoryArticle->contains($titleCategoryArticle)) {
            $this->titleCategoryArticle[] = $titleCategoryArticle;
        }

        return $this;
    }

    public function removeTitleCategoryArticle(CategoryArticle $titleCategoryArticle): self
    {
        $this->titleCategoryArticle->removeElement($titleCategoryArticle);

        return $this;
    }
}
