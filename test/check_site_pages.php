<?php

declare(strict_types = 1);

require_once __DIR__ . "/../vendor/autoload.php";

require_once __DIR__ . "/../src/functions.php";

use SiteChecker\SiteChecker;

//function check_links_contains_link($links, $name, $url): bool
//{
//    foreach ($links as $link) {
//        if ($link['caption'] === $name &&
//            $link['href'] === $url) {
//            return true;
//        }
//    }
//
//    return false;
//}
//
//
//function extract_links_from_html(string $html)
//{
//    $document = FluentDOM::load(
//        $html,
//        'text/html',
//        [FluentDOM\Loader\Options::IS_STRING => true]
//    );
//
//    $links = [];
//
//    foreach ($document('//a[@href]') as $a) {
//        $links[] = [
//            'caption' => (string)$a,
//            'href' => $a['href']
//        ];
//    }
//
//    return $links;
//}
//
//$pages_to_check = [
//  '/rfc_codex' => [
//    [
//      'Edit page',
//       'https://github.com/PHPOpenDocs/PHPOpenDocs/blob/main/app/public/rfc_codex/index.php'
//    ],
//    [
//      "© PHP OpenDocs",
//      'https://github.com/Danack/RfcCodex/blob/master/LICENSE'
//    ],
//  ],
//  '/rfc_codex/array_key_casting' => [
//    [
//      'Edit page',
//      'https://github.com/PHPOpenDocs/PHPOpenDocs/blob/main/src/RfcCodexOpenDocs/Pages.php',
//    ],
//    [
//      'Edit content',
//      'https://github.com/Danack/RfcCodex/blob/master/array_key_casting.md',
//    ],
//    [
//        "© Danack",
//        "https://github.com/Danack/RfcCodex/blob/master/LICENSE"
//    ],
//  ]
//];

$base_domain = 'http://local.phpopendocs.com';
$errors = [];

//foreach ($pages_to_check as $page_url => $details) {
//    // Get the page
//    $url = $base_domain . $page_url;
//
//    [$statusCode, $body, $headers] = fetchUri($url, 'GET');
//
//    if ($statusCode !== 200) {
//        $errors[] = "page $page_url is not 200 OK, but instead $statusCode";
//        continue;
//    }
//
//    // Extract the links
//    $links = extract_links_from_html($body);
//
//    foreach ($details as $detail) {
//        if (check_links_contains_link($links, $detail[0], $detail[1]) === false) {
//            $errors[] = sprintf(
//                "page $page_url does not contain link with caption [%s] and url [%s]",
//                $detail[0],
//                $detail[1]
//            );
//        }
//    }
//}

$excluded_urls = [
    '/system/exception_test'
];

$siteChecker = new SiteChecker(
    'http://local.phpopendocs.com',
    '/',
    $excluded_urls
);

$siteChecker->run();

$errors = $siteChecker->getErrors();

if (count($errors) > 0) {
    echo "Checked " . $siteChecker->numberOfPagesChecked() . " pages.\n";
    echo "There were " . count($errors) . " errors:\n";
    foreach ($errors as $error) {
        printf(
            "Url: %s, status: %s, message %s - linked from %s\n",
            $error->getUrl(),
            $error->getStatus(),
            $error->getErrorMessage(),
            $error->getOriginUrl()
        );
    }

    exit(-1);
}

echo "Checked " . $siteChecker->numberOfPagesChecked() . " pages without errors.\n";

$siteChecker->dumpPagesChecked();