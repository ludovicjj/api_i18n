<?php

namespace App\State;

use ApiPlatform\State\ProcessorInterface;
use ApiPlatform\Metadata\Operation;
use App\DTO\ArticleInput;
use App\Entity\Article;
use App\Entity\ArticleTranslation;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;


class ArticleProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly ArticleRepository $articleRepository
    ) {
    }

    public function process($data, Operation $operation, array $uriVariables = [], array $context = []): Article
    {
        $article = $this->articleRepository->find($uriVariables['id']);

        if (!$article instanceof Article) {
            throw new Exception('Not found article to update');
        }

        $article = ArticleInput::createOrUpdateEntity($data, $article);

        /** @var ArticleTranslation $translation */
        foreach ($article->getTranslations() as $translation) {
            if (!$translation->getId()) {
                $this->entityManager->persist($translation);
            }
        }

        $this->entityManager->flush();

        return $article;
    }
}