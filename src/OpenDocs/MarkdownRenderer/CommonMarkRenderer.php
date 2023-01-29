<?php

declare(strict_types = 1);

namespace OpenDocs\MarkdownRenderer;

use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\GithubFlavoredMarkdownExtension;
use League\CommonMark\GithubFlavoredMarkdownConverter;

use League\CommonMark\CommonMarkConverter;

use League\CommonMark\Environment\Environment;
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

        $config = [
            'heading_permalink' => [
                'html_class' => 'heading-permalink',
                'id_prefix' => '',
                'fragment_prefix' => '',
                'insert' => 'after',
                'title' => 'Permalink',
                'symbol' => "\u{00A0}\u{00A0}🔗",
            ],
        ];

        $environment = new Environment($config);
        $environment->addExtension(new HeadingPermalinkExtension());
        $environment->addExtension(new CommonMarkCoreExtension());
        $environment->addExtension(new GithubFlavoredMarkdownExtension());

        $converter = new MarkdownConverter($environment);

        $wat = $converter->convert($markdown);

        return $wat->getContent();
    }
}
