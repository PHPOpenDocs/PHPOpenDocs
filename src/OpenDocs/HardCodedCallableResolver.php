<?php

declare(strict_types = 1);

namespace OpenDocs;

use RuntimeException;
use Auryn\Injector;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use SlimAuryn\RouteParams;
use Slim\Interfaces\CallableResolverInterface;
use SlimAuryn\Exception\UnresolvableCallableException;
use SlimAuryn\SlimAurynException;

class HardCodedCallableResolver implements CallableResolverInterface
{
    public function __construct(
        private Injector $injector,
        private array $resultMappers
    ) {
    }

    private function wrapCallableWithResultMappers($resolvedCallable)
    {
        $fn = function (
            Request $request,
            Response $response,
            array $routeArguments
        ) use ($resolvedCallable) {

            $injector = $this->injector;

            $injector->alias(Request::class, get_class($request));
            $injector->share($request);
            foreach ($routeArguments as $key => $value) {
                $injector->defineParam($key, $value);
            }

            $routeParams = new RouteParams($routeArguments);
            $injector->share($routeParams);

            $result = $injector->execute($resolvedCallable);

            return $this->convertStubResponseToFullResponse(
                $result,
                $request,
                $response
            );
        };

        return $fn;
    }

    private function convertStubResponseToFullResponse(
        mixed $result,
        Request $request,
        Response $response
    ): Response {
        // Test each of the result mapper, and use an appropriate one.
        foreach ($this->resultMappers as $type => $mapCallable) {
            if ((is_object($result) && $result instanceof $type) ||
                gettype($result) === $type) {
                return $this->injector->execute($mapCallable, [$result, $request, $response]);
            }
        }

        // Allow PSR responses to just be passed back.
        // This is after the responseHandlerList is processed, to
        // allow custom handlers for specfic types to take precedence.
        if ($result instanceof Response) {
            return $result;
        }


        throw SlimAurynException::unknownResultType($result);
    }

    /**
     * Resolve toResolve into a closure that that the router can dispatch.
     *
     * If toResolve is of the format 'class:method', then try to extract 'class'
     * from the container otherwise instantiate it and then dispatch 'method'.
     *
     * @param mixed $toResolve
     *
     * @return callable
     *
     * @throws RuntimeException if the callable does not exist
     * @throws RuntimeException if the callable is not resolvable
     */
    public function resolve($toResolve): callable
    {
        if ($toResolve instanceof \Closure) {
            return $this->wrapCallableWithResultMappers($toResolve);
        }

        if (is_callable($toResolve)) {
            return $this->wrapCallableWithResultMappers($toResolve);
        }

        if (is_string($toResolve) !== true) {
            throw new UnresolvableCallableException(sprintf(
                '%s is not resolvable',
                is_array($toResolve) || is_object($toResolve) ? json_encode($toResolve) : $toResolve
            ));
        }

        if (class_exists($toResolve) === true) {
            if (method_exists($toResolve, '__invoke') === true) {
                return $this->wrapCallableWithResultMappers([$toResolve, '__invoke']);
            }
        }

        $parts = explode('::', $toResolve);

        if (count($parts) === 2) {
            $class_name = $parts[0];
            $method_name = $parts[1];

            if (class_exists($class_name) === true) {
                if (method_exists($class_name, $method_name) === true) {
                    return $this->wrapCallableWithResultMappers($toResolve);
                }
            }
        }

        throw new UnresolvableCallableException(sprintf(
            '%s is not resolvable',
            is_array($toResolve) || is_object($toResolve) ? json_encode($toResolve) : $toResolve
        ));
    }
}
