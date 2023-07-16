<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use ApiPlatform\Metadata\CollectionOperationInterface;
use App\Filter\TranslationFilter;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;

class ArticleProvider implements ProviderInterface
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        /** @var ArticleRepository $repository */
        $repository = $this->entityManager->getRepository($operation->getClass());

        $locale = $context[TranslationFilter::LOCALE_FILTER_IN_CONTEXT] ?? null;

        if ($operation instanceof CollectionOperationInterface) {
            if ($locale) {
                return $repository->getArticlesByLocale($locale);
            }

            return $repository->findAll();
        }

        if ($locale) {
            return $repository->getArticleByLocale($uriVariables['id'], $locale);
        }

        return $repository->findOneBy(['id' => $uriVariables['id']]);
    }
}