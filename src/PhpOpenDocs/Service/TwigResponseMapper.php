<?php

declare(strict_types = 1);

namespace Osf\Service;

use SlimAuryn\Response\TwigResponse;
use Twig_Environment as Twig;
use Psr\Http\Message\ResponseInterface;

class TwigResponseMapper
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
        TwigResponse $twigResponse,
        ResponseInterface $originalResponse
    ) : ResponseInterface {
        $html = $this->twig->render(
            $twigResponse->getTemplateName(),
            $twigResponse->getParameters()
        );

        $status = $twigResponse->getStatus();
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
