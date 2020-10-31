<?php

declare(strict_types = 1);

function memory_debug()
{
    $memoryUsed = memory_get_usage(true);
    return "<!-- " . number_format($memoryUsed) . " -->";
}

function request_nonce(\Osf\Service\RequestNonce $requestNonce)
{
    return $requestNonce->getRandom();
}


function emitDnsPreFetch()
{
    $html = '';
    $domains = [
        'https://api.stripe.com',
        'https://checkout.stripe.com',
        'https://q.stripe.com',
        'https://js.stripe.com/',
        'https://m.stripe.com',
        'https://m.stripe.network',
        getConfig(\Osf\Config::STRIPE_PLATFORM_API_DOMAIN)
    ];

    foreach ($domains as $domain) {
        $html .= sprintf(
            "<link rel='dns-prefetch' href='%s'>\n",
            $domain
        );
    }

    return $html;
}
