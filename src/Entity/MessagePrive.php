<?php

namespace App\Entity;

use App\Repository\MessagePriveRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MessagePriveRepository::class)
 */
class MessagePrive
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
    private $contenue;

    /**
     * @ORM\ManyToOne(targetEntity=user::class, inversedBy="messagePrives")
     */
    private $user_receiver;

    /**
     * @ORM\ManyToOne(targetEntity=user::class, inversedBy="messagePrives")
     */
    private $user_issuer;

    /**
     * @ORM\ManyToOne(targetEntity=conversation::class, inversedBy="messagePrives")
     */
    private $conversation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContenue(): ?string
    {
        return $this->contenue;
    }

    public function setContenue(string $contenue): self
    {
        $this->contenue = $contenue;

        return $this;
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

    public function getConversation(): ?conversation
    {
        return $this->conversation;
    }

    public function setConversation(?conversation $conversation): self
    {
        $this->conversation = $conversation;

        return $this;
    }
}
