<?php

namespace App\Entity;

use App\Repository\RepertoireRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\UploadedFile;
/**
 * @ORM\Entity(repositoryClass="App\Repository\RepertoireRepository")
 * @Vich\Uploadable
 */
class Repertoire
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="repertoires")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adress;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $country;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $postalCode;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $phoneHome;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $indPhoneHome;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $indPhone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $phonePro;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $indPhonePro;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $emailPro;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture;

    /**
     * @Vich\UploadableField(mapping="products_image", fileNameProperty="picture")
     */
    private $pictureFile;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;


    public function getPictureFile(): ?File 
    {
        return $this->pictureFile;
    }

    public function setPictureFile(?File $pictureFile = null)
    {
        $this->pictureFile = $pictureFile;
        if($this->pictureFile instanceof UploadedFile){
            $this->updated_at = new \DateTime('now');
        }
        return $this;
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

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getPostalCode(): ?int
    {
        return $this->postalCode;
    }

    public function setPostalCode(?int $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getPhoneHome(): ?int
    {
        return $this->phoneHome;
    }

    public function setPhoneHome(?int $phoneHome): self
    {
        $this->phoneHome = $phoneHome;

        return $this;
    }

    public function getIndPhoneHome(): ?string
    {
        return $this->indPhoneHome;
    }

    public function setIndPhoneHome(?string $indPhoneHome): self
    {
        $this->indPhoneHome = $indPhoneHome;

        return $this;
    }

    public function getPhone(): ?int
    {
        return $this->phone;
    }

    public function setPhone(?int $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getIndPhone(): ?string
    {
        return $this->indPhone;
    }

    public function setIndPhone(?string $indPhone): self
    {
        $this->indPhone = $indPhone;

        return $this;
    }

    public function getPhonePro(): ?string
    {
        return $this->phonePro;
    }

    public function setPhonePro(?string $phonePro): self
    {
        $this->phonePro = $phonePro;

        return $this;
    }

    public function getIndPhonePro(): ?string
    {
        return $this->indPhonePro;
    }

    public function setIndPhonePro(?string $indPhonePro): self
    {
        $this->indPhonePro = $indPhonePro;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getEmailPro(): ?string
    {
        return $this->emailPro;
    }

    public function setEmailPro(?string $emailPro): self
    {
        $this->emailPro = $emailPro;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

}
