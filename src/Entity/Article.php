<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\DTO\ArticleInput;
use App\Filter\TranslationFilter;
use App\Repository\ArticleRepository;
use App\State\ArticleProcessor;
use App\State\ArticleProvider;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Locastic\ApiPlatformTranslationBundle\Model\AbstractTranslatable;
use Locastic\ApiPlatformTranslationBundle\Model\TranslationInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
#[ApiResource(
    operations: [
        new Get(
            normalizationContext: [
                'groups' => ['translations']
            ]
        ),
        new GetCollection(
            normalizationContext: [
                'groups' => ['translations']
            ]
        ),
        new Post(
            normalizationContext: [
                'groups' => ['translations']
            ]
        ),
        new Put(
            normalizationContext: [
                'groups' => ['translations', 'article:read']
            ],
            denormalizationContext: [
                'groups' => ['article:write']
            ],
            input: ArticleInput::class,
            processor: ArticleProcessor::class
        ),
    ],
    normalizationContext: [
        'groups' => ['article:read']
    ],
    denormalizationContext: [
        'groups' => ['article:write']
    ],
    provider: ArticleProvider::class
    //filters: ['translation.groups']
)]
#[ApiFilter(TranslationFilter::class)]
class Article extends AbstractTranslatable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['article:read'])]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['article:read'])]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['article:read'])]
    private ?string $content = null;

    #[ORM\OneToMany(
        mappedBy: "translatable",
        targetEntity: ArticleTranslation::class,
        cascade: ['persist'],
        fetch: "LAZY",
        orphanRemoval: true,
        indexBy:"locale"
    )]
    #[Assert\Valid]
    #[Groups(['article:write', 'translations'])]
    protected Collection $translations;

    protected ?string $currentLocale = 'fr';

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    protected function createTranslation(): TranslationInterface
    {
        return new ArticleTranslation();
    }
}
