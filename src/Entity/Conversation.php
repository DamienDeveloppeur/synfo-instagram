<?php

namespace App\Entity;

use App\Repository\ConversationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ConversationRepository::class)
 */
class Conversation
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
    private $type;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity=MessagePrive::class, mappedBy="conversation")
     */
    private $messagePrives;

    public function __construct()
    {
        $this->messagePrives = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

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

    /**
     * @return Collection|MessagePrive[]
     */
    public function getMessagePrives(): Collection
    {
        return $this->messagePrives;
    }

    public function addMessagePrife(MessagePrive $messagePrife): self
    {
        if (!$this->messagePrives->contains($messagePrife)) {
            $this->messagePrives[] = $messagePrife;
            $messagePrife->setConversation($this);
        }

        return $this;
    }

    public function removeMessagePrife(MessagePrive $messagePrife): self
    {
        if ($this->messagePrives->removeElement($messagePrife)) {
            // set the owning side to null (unless already changed)
            if ($messagePrife->getConversation() === $this) {
                $messagePrife->setConversation(null);
            }
        }

        return $this;
    }
}
