<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\FileRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     normalizationContext={
 *          "groups"={"post:read"}
 *     },
 *     collectionOperations={
 *          "post"={
 *              "controller"=UploadController::class,
 *              "validation_groups"={"Default", "post:read"}
 *          },
 *          "get"
 *     },
 *     itemOperations={
 *          "get"
 *     }
 * )
 * @ORM\Entity(repositoryClass=FileRepository::class)
 */
class File
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("post:read")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("post:read")
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=DataFile::class, mappedBy="file", cascade="persist")
     * @Groups("post:read")
     * @Assert\NotBlank
     */
    private $data;

    public function __construct()
    {
        $this->data = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|DataFile[]
     */
    public function getData(): Collection
    {
        return $this->data;
    }

    public function addData(DataFile $data): self
    {
        if (!$this->data->contains($data)) {
            $this->data[] = $data;
            $data->setFile($this);
        }

        return $this;
    }

    public function removeData(DataFile $data): self
    {
        if ($this->data->removeElement($data)) {
            // set the owning side to null (unless already changed)
            if ($data->getFile() === $this) {
                $data->setFile(null);
            }
        }

        return $this;
    }
}
