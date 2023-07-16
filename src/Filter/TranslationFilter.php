<?php

namespace App\Filter;

use ApiPlatform\Serializer\Filter\FilterInterface;
use Symfony\Component\HttpFoundation\Request;

class TranslationFilter implements FilterInterface
{
    final public const LOCALE_FILTER_IN_CONTEXT = 'article_locale_filter';

    public function getDescription(string $resourceClass): array
    {
        return [
            'locale' => [
                'property' => null,
                'type' => 'string',
                'required' => false,
                'description' => 'Search article translation by locale',
            ]
        ];
    }
    public function apply(Request $request, bool $normalization, array $attributes, array &$context): void
    {
        $locale = $request->query->get("locale");

        if (!$locale) {
            return;
        }

        $context[self::LOCALE_FILTER_IN_CONTEXT] = $locale;
    }
}