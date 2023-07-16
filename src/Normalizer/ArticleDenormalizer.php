<?php

namespace App\Normalizer;

use App\DTO\ArticleInput;
use App\Entity\Article;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class ArticleDenormalizer{

}
//
//class ArticleDenormalizer implements DenormalizerInterface, DenormalizerAwareInterface
//{
//    use DenormalizerAwareTrait;
//
//    private const ALREADY_CALLED = 'ARTICLE_INPUT_DENORMALIZER_ALREADY_CALLED';
//
//    public function supportsDenormalization(mixed $data, string $type, string $format = null, array $context = []): bool
//    {
//        if (isset($context[self::ALREADY_CALLED])) {
//            return false;
//        }
//
//        return $type === Article::class;
//    }
//
//    public function denormalize(mixed $data, string $type, string $format = null, array $context = [])
//    {
//        $context[self::ALREADY_CALLED] = true;
//        $context[AbstractNormalizer::OBJECT_TO_POPULATE] = $this->createDto($context);
//
//        return $this->denormalizer->denormalize($data, $type, $format, $context);
//    }
//
//    private function createDTO(array $context): ArticleInput
//    {
//        $entity = $context['object_to_populate'] ?? null;
//
//        return ArticleInput::createFromEntity($entity);
//    }
//}