<?php

namespace App\DTO;

use Symfony\Component\Serializer\Annotation\Groups;

class ArticleTranslationInput
{
    #[Groups(['article:write', 'translations'])]
    public ?string $title = null;

    #[Groups(['article:write', 'translations'])]
    public ?string $description = null;

    #[Groups(['article:write', 'translations'])]
    public ?string $content = null;

    #[Groups(['article:write', 'translations'])]
    public ?string $locale = null;
}
