<?php

namespace App\DTO;


use App\Entity\Article;
use App\Entity\ArticleTranslation;
use Symfony\Component\Serializer\Annotation\Groups;

class ArticleInput
{
    #[Groups(['article:write', 'translations'])]
    public ?string $title = null;

    #[Groups(['article:write', 'translations'])]
    public ?string $description = null;

    #[Groups(['article:write', 'translations'])]
    public ?string $content = null;

    #[Groups(['article:write', 'translations'])]
    /**
     * @var ArticleTranslationInput[] $translations
     */
    public array $translations;

    public static function createOrUpdateEntity(
        ArticleInput $dto,
        Article $article
    ): Article {
        $article
            ->setTitle($dto->title)
            ->setDescription($dto->description)
            ->setContent($dto->content);

        foreach ($dto->translations as $articleTranslationInput) {
            /** @var ArticleTranslation $articleTranslation */
            // find translation by locale OR create new one and auto define locale
            // maybe can check if here, if ArticleTranslationDTO contain allowed locale
            $articleTranslation = $article->getTranslation($articleTranslationInput->locale);

            $articleTranslation
                ->setTitle($articleTranslationInput->title)
                ->setDescription($articleTranslationInput->description)
                ->setContent($articleTranslationInput->content);

            $article->addTranslation($articleTranslation);
        }

        return $article;
    }
}