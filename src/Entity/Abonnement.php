<?php

namespace App\Entity;

use App\Repository\AbonnementRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AbonnementRepository::class)
 */
class Abonnement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=user::class, inversedBy="abonnements")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user_receiver;

    /**
     * @ORM\ManyToOne(targetEntity=user::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $user_issuer;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserReceiver(): ?user
    {
        return $this->user_receiver;
    }

    public function setUserReceiver(?user $user_receiver): self
    {
        $this->user_receiver = $user_receiver;

        return $this;
    }

    public function getUserIssuer(): ?user
    {
        return $this->user_issuer;
    }

    public function setUserIssuer(?user $user_issuer): self
    {
        $this->user_issuer = $user_issuer;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
