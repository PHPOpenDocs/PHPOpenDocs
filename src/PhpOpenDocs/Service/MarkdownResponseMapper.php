<?php

declare(strict_types = 1);

namespace PhpOpenDocs\Service;

use PhpOpenDocs\Response\MarkdownResponse;
use Twig_Environment as Twig;
use Psr\Http\Message\ResponseInterface;
use Parsedown;

class MarkdownResponseMapper
{
    /** @var Twig */
    private $twig;

    /**
     * TwigResponseMapper constructor.
     * @param Twig $twig
     */
    public function __construct(Twig $twig)
    {
        $this->twig = $twig;
    }

    public function __invoke(
        MarkdownResponse $markdownResponse,
        ResponseInterface $originalResponse
    ) : ResponseInterface {

        $parsedown = new Parsedown();

        $filename = sprintf(
            __DIR__ . '/../../../app/markdown/%s',
            $markdownResponse->getTemplateName()
        );

        $markdown = @file_get_contents($filename);

        if ($markdown === false) {
            throw new \Exception(
                "Failed to load markdown file " . $markdownResponse->getTemplateName() . " frmo file " . $filename
            );
        }

        $markdownHtml = $parsedown->text($markdown);

        $html = $this->twig->render(
            'pages/markdown.html',
            [ 'markdownHtml' => $markdownHtml]
        );

        $status = $markdownResponse->getStatus();
        $reasonPhrase = getReasonPhrase($status);

        $response = $originalResponse->withStatus($status, $reasonPhrase);
        // TODO - put these back in if twigResponse ever gets
        // the ability to have headers set
//        foreach ($builtResponse->getHeaders() as $key => $value) {
//            $response = $response->withAddedHeader($key, $value);
//        }
        $response->getBody()->write($html);

        return $response;
    }
}
