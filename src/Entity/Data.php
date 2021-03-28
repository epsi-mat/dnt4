<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\DataRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 * normalizationContext={
 *         "groups"={"post"}
 *     },
 *     collectionOperations={
 *         "post"={
 *           "deserialize"=true,
 *         },
 *         "get"
 *     },
 *     itemOperations={
 *         "get"
 *     })
 * @ORM\Entity(repositoryClass=DataRepository::class)
 * 
 */
class Data
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"get", "post"})
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"get", "post"})
     */
    private $value;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }
}
