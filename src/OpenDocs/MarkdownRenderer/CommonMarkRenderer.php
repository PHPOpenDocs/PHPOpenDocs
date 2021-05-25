<?php

declare(strict_types = 1);

namespace OpenDocs\MarkdownRenderer;

use League\CommonMark\GithubFlavoredMarkdownConverter;

use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment;
use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkExtension;
use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkRenderer;
use League\CommonMark\Normalizer\SlugNormalizer;
use League\CommonMark\MarkdownConverter;

class CommonMarkRenderer implements MarkdownRenderer
{

    public function renderFile(string $filepath): string
    {
        $markdown = @file_get_contents($filepath);

        if ($markdown === false) {
            throw MarkdownRendererException::fileNotFound($filepath);
        }

        return $this->render($markdown);
    }

    public function render(string $markdown): string
    {
        $environment = Environment::createGFMEnvironment();

        $environment->addExtension(new HeadingPermalinkExtension());

        $params = [
            'heading_permalink' => [
                'html_class' => 'heading-permalink',
                'id_prefix' => 'user-content',
                'insert' => 'after',
                'title' => 'Permalink',
                'symbol' => "\u{00A0}\u{00A0}🔗",
                'slug_normalizer' => new SlugNormalizer(),
            ],
        ];

        $environment->mergeConfig($params);

        $converter = new MarkdownConverter($environment);

        return $converter->convertToHtml($markdown);
    }
}
