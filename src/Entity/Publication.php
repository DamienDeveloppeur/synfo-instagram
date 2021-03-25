<?php

namespace App\Entity;

use App\Repository\PublicationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PublicationRepository::class)
 */
class Publication
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
    private $contenu;


    /**
     * @ORM\Column(type="date")
     */
    private $CreatedAt;
    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="publications")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=Photo::class, mappedBy="publication", orphanRemoval=true)
     */
    private $photos;

    /**
     * @ORM\OneToMany(targetEntity=LikePublication::class, mappedBy="publication")
     */
    private $likePublications;


    public function __construct()
    {
        $this->photos = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
        $this->likePublications = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->CreatedAt;
    }

    public function setCreatedAt(\DateTimeInterface $CreatedAt): self
    {
        $this->CreatedAt = $CreatedAt;

        return $this;
    }

    public function getUser(): ?user
    {
        return $this->user_id;
    }

    public function setUser(?user $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Photo[]
     */
    public function getPhotos(): Collection
    {
        return $this->photos;
    }

    public function addPhoto(Photo $photo): self
    {
        if (!$this->photos->contains($photo)) {
            $this->photos[] = $photo;
            $photo->setPublication($this);
        }

        return $this;
    }

    public function removePhoto(Photo $photo): self
    {
        if ($this->photos->removeElement($photo)) {
            // set the owning side to null (unless already changed)
            if ($photo->getPublication() === $this) {
                $photo->setPublication(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|LikePublication[]
     */
    public function getLikePublications(): Collection
    {
        return $this->likePublications;
    }

    public function addLikePublication(LikePublication $likePublication): self
    {
        if (!$this->likePublications->contains($likePublication)) {
            $this->likePublications[] = $likePublication;
            $likePublication->setPublication($this);
        }

        return $this;
    }

    public function removeLikePublication(LikePublication $likePublication): self
    {
        if ($this->likePublications->removeElement($likePublication)) {
            // set the owning side to null (unless already changed)
            if ($likePublication->getPublication() === $this) {
                $likePublication->setPublication(null);
            }
        }

        return $this;
    }
}
