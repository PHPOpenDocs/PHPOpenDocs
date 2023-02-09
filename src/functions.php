<?php

declare(strict_types = 1);

/**
 * This file holds functions that are required by all environments.
 */

use OpenDocs\Breadcrumbs;
use OpenDocs\CopyrightInfo;
use OpenDocs\EditInfo;
use OpenDocs\SectionList;
use PHPOpenDocs\Data\ContentPolicyViolationReport;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use SlimAuryn\Response\HtmlResponse;
use SlimAuryn\Response\StubResponse;
use function SlimAuryn\mapStubResponseToPsr7;

///**
// * @param array<mixed> $indexes
// * @return mixed
// * @throws Exception
// */
//function getConfig(array $indexes)
//{
//    static $options = null;
//    if ($options === null) {
//        require __DIR__ . '/../config.php';
//        require __DIR__ . '/../autoconf.php';
//
//        $staticConfigOptions = getStaticConfigOptions();
//        $generatedConfigOptions = getGeneratedConfigOptions();
//
//        $options = array_merge_recursive($staticConfigOptions, $generatedConfigOptions);
//    }
//
//    $data = $options;
//
//    foreach ($indexes as $index) {
//        if (array_key_exists($index, $data) === false) {
//            throw new \Exception("Config doesn't contain an element for $index, for indexes [" . implode('|', $indexes) . "]");
//        }
//
//        $data = $data[$index];
//    }
//
//    return $data;
//}


/**
 * Decode JSON with actual error detection
 * @return mixed
 */
function json_decode_safe(?string $json)
{
    if ($json === null) {
        throw new \PHPOpenDocs\Exception\JsonException("Error decoding JSON: cannot decode null.");
    }

    $data = json_decode($json, true);

    if (json_last_error() === JSON_ERROR_NONE) {
        return $data;
    }

    $parser = new \Seld\JsonLint\JsonParser();
    $parsingException = $parser->lint($json);

    if ($parsingException !== null) {
        throw $parsingException;
    }

    if ($data === null) {
        throw new \PHPOpenDocs\Exception\JsonException("Error decoding JSON: null returned.");
    }

    throw new \PHPOpenDocs\Exception\JsonException("Error decoding JSON: " . json_last_error_msg());
}


/**
 * @param mixed $data
 * @param int $options
 * @return string
 * @throws Exception
 */
function json_encode_safe($data, $options = 0): string
{
    $result = json_encode($data, $options);

    if ($result === false) {
        throw new \Exception("Failed to encode data as json: " . json_last_error_msg());
    }

    return $result;
}


/**
 * Get the options to use when hashing passwords.
 * The cost should be tuned for the hash to take something like a
 * quarter of a second of CPU time to hash.
 *
 * @return array<mixed>
 */
function get_password_options(): array
{
    $options = [
        'cost' => 12,
    ];

    return $options;
}

/**
 * @param string $password
 * @return string
 */
function generate_password_hash(string $password): string
{
    $options = get_password_options();

    return password_hash($password, PASSWORD_BCRYPT, $options);
}

function getClientIpAddress() : string
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {   //shared internet
        return $_SERVER['HTTP_CLIENT_IP'];
    }

    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {   // from load balancer
        $ipString = $_SERVER['HTTP_X_FORWARDED_FOR'];
        $ipParts = explode(',', $ipString);

        // TODO - validate this.
        return trim($ipParts[0]);
    }

    return $_SERVER['REMOTE_ADDR'];
}

/**
 * Recursive directory search
 * @param string $folder
 * @param string $pattern
 * @return array<string, string>
 */
function recursiveSearch(string $folder, string $pattern)
{
    $dir = new \RecursiveDirectoryIterator($folder);
    $ite = new \RecursiveIteratorIterator($dir);
    $files = new \RegexIterator($ite, $pattern, \RegexIterator::GET_MATCH);
    $fileList = array();
    foreach ($files as $file) {
        $fileList = array_merge($fileList, $file);
    }
    return $fileList;
}


/**
 * @param string $name
 * @param mixed $value
 * @return mixed
 * @throws Exception
 */
function convertToValue(string $name, $value)
{
    if (is_scalar($value) === true) {
        return $value;
    }
    if ($value === null) {
        return null;
    }

    $callable = [$value, 'toArray'];
    if (is_object($value) === true && is_callable($callable)) {
        return $callable();
    }
    if (is_object($value) === true && $value instanceof \DateTime) {
        return $value->format(\PHPOpenDocs\App::DATE_TIME_EXACT_FORMAT);
    }

    if (is_array($value) === true) {
        $values = [];
        foreach ($value as $key => $entry) {
            $values[$key] = convertToValue($key, $entry);
        }

        return $values;
    }

    $message = "Unknown error converting to param '$name' to value.";

    if (is_object($value) === true) {
        $message = "Unsupported type [" . gettype($value) . "] of class [" . get_class($value) . "] for toArray for property $name.";
    }

    throw new \Exception($message);
}


/**
 * Fetch data and return statusCode, body and headers
 * @param string $uri
 * @param string $method
 * @param array<mixed> $queryParams
 * @param string|null $body
 * @param array<mixed> $headers
 * @return array<mixed>
 */
function fetchUri(string $uri, string $method, array $queryParams = [], string $body = null, array $headers = [])
{
    $query = http_build_query($queryParams);
    $curl = curl_init();

    curl_setopt($curl, CURLOPT_URL, $uri . $query);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);

    $allHeaders = [];

    if ($body !== null) {
        $allHeaders[] = 'Content-Type: application/json';
        curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
    }


    foreach ($headers as $header) {
        $allHeaders[] = $header;
    }

    curl_setopt($curl, CURLOPT_HTTPHEADER, $allHeaders);

    $headers = [];
    $handleHeaderLine = function ($curl, $headerLine) use (&$headers) {
        $headers[] = $headerLine;
        return strlen($headerLine);
    };
    curl_setopt($curl, CURLOPT_HEADERFUNCTION, $handleHeaderLine);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $body = curl_exec($curl);
    $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    return [$statusCode, $body, $headers];
}

/**
 * Fetch data and only return successful request
 * @param string $uri
 * @param array<string, string> $headers
 * @return mixed
 */
function fetchDataWithHeaders(string $uri, array $headers)
{
    [$statusCode, $body, $responseHeaders] = fetchUri($uri, 'GET', [], null, $headers);

    if ($statusCode === 200) {
        return json_decode_safe($body);
    }

    throw new \Exception("Failed to fetch data from " . $uri);
}

/**
 * Fetch data and only return successful request
 * @param string $uri
 * @return mixed
 */
function fetchData(string $uri)
{
    [$statusCode, $body, $headers] = fetchUri($uri, 'GET');

    if ($statusCode === 200) {
        return json_decode_safe($body);
    }

    throw new \Exception("Failed to fetch data from " . $uri);
}


/**
 * Escape characters that are meaningful in SQL like searches
 * @param string $string
 * @return mixed
 */
function escapeMySqlLikeString(string $string)
{
    return str_replace(
        ['\\', '_', '%', ],
        ['\\\\', '\\_', '\\%'],
        $string
    );
}

// Docker IP addresses are apparently "172.XX.X.X",
// Which should be in an IPV4 PRIVATE ADDRESS SPACE
// https://www.arin.net/knowledge/address_filters.html
function isIpAddressDockerBoxHost(string $ipAddress): bool
{
    if (substr($ipAddress, 0, 4) !== '172.') {
        return false;
    }

    $ipParts = explode('.', $ipAddress);

    if (count($ipParts) !== 4) {
        return false;
    }

    $ipPart1 = (int)$ipParts[1];
    if ($ipPart1 >= 16 && $ipPart1 <= 31) {
        return true;
    }

    return false;
}

function isIpAddressSameCluster(string $ipAddress): bool
{
    if (strpos($ipAddress, '10.') === 0) {
        return true;
    }

    return false;
}

function showRawCharacters(string $result): string
{
    $resultInHex = unpack('H*', $result);
    $resultInHex = $resultInHex[1];

    $bytes = str_split($resultInHex, 2);
    $resultSeparated = implode(', ', $bytes); //byte safe
    return $resultSeparated;
}


/**
 * @param string $prefix
 * @param array<mixed> $entries
 * @return array<mixed>
 */
function buildInString(string $prefix, $entries): array
{
    $strings = [];
    $params = [];
    $count = 0;

    foreach ($entries as $entry) {
        $currentString = ':' . $prefix . $count;
        $strings[] = $currentString;
        $params[$currentString] = $entry;
        $count += 1;
    }

    return [implode(', ', $strings), $params];
}


/**
 * @param array<mixed> $expected
 * @param array<mixed> $actual
 * @param array<string|int> $currentKeyPath
 * @return array<mixed>
 */
function compareArrays(array $expected, array $actual, array $currentKeyPath = [])
{
    $errors = [];

    ksort($expected);
    ksort($actual);
    foreach ($expected as $key => $value) {
        $keyPath = $currentKeyPath;
        $keyPath[] = $key;

        if (array_key_exists($key, $actual) === false) {
            $errors[implode('.', $keyPath)] = "Missing key should be value " . \json_encode($expected[$key]);
        }
        else if (is_array($expected[$key]) === true && is_array($actual[$key]) === true) {
            $deeperErrors = compareArrays($expected[$key], $actual[$key], $keyPath);
            $errors = array_merge($errors, $deeperErrors);
        }
        else {
            $expectedValue = \json_encode($expected[$key]);
            $actualValue = \json_encode($actual[$key]);
            if ($expectedValue !== $actualValue) {
                $errors[implode('.', $keyPath)] = "Values don't match.\nExpected " . $expectedValue . "\n vs actual " . $actualValue . "\n";
            }
        }

        unset($actual[$key]);
    }

    foreach ($actual as $key => $value) {
        $keyPath = $currentKeyPath;
        $keyPath[] = $key;
        $errors[implode('.', $keyPath)] = "Has extra value of " . \json_encode($value);
    }

    return $errors;
}

function getMimeTypeFromFilename(string $filename): string
{
    $contentTypesByExtension = [
        'pdf' => 'application/pdf',
        'jpg' => 'image/jpg',
        'png' => 'image/png',
    ];

    $extension = pathinfo($filename, PATHINFO_EXTENSION);
    $extension = strtolower($extension);

    if (array_key_exists($extension, $contentTypesByExtension) === false) {
        throw new \Exception("Unknown file type [$extension]");
    }

    return $contentTypesByExtension[$extension];
}

/**
 * @param array<string> $dataHeaders
 * @param array<array<string>> $dataRows
 * @return string
 */
function str_putcsv(array $dataHeaders, array $dataRows): string
{
    # Generate CSV data from array
    $fh = fopen('php://temp', 'rw'); # don't create a file, attempt
    # to use memory instead

    assert($fh !== false, "File handle is false.");

    /** @var $fh \resource */
    if ($dataHeaders !== null) {
        fputcsv($fh, $dataHeaders);
    }

    foreach ($dataRows as $row) {
        fputcsv($fh, $row);
    }
    rewind($fh);
    $csv = stream_get_contents($fh);
    fclose($fh);

    return $csv;
}

function getReasonPhrase(int $status): string
{
    $knownStatusReasons = [
        420 => 'Enhance Your Calm',
        421 => 'what the heck',
        512 => 'Server known limitation',
    ];

    return $knownStatusReasons[$status] ?? '';
}

function createId(): string
{
    return bin2hex(random_bytes(16));
}

/**
 * @return int
 * @throws Exception
 */
function getMemoryLimit()
{
    $memoryLimit = ini_get('memory_limit');

    if ($memoryLimit === false) {
        throw new \Exception("Failed to get memory_limit.");
    }

    if (strrpos($memoryLimit, 'M') === (strlen($memoryLimit) - 1)) {
        $memoryLimitValue = ((int)$memoryLimit) * 1024 * 1024;
    }
    else if (strrpos($memoryLimit, 'G') === (strlen($memoryLimit))) {
        $memoryLimitValue = ((int)$memoryLimit) * 1024 * 1024 * 1024;
    }
    else {
        throw new \Exception("Could not understand memory limit of [$memoryLimit]");
    }

    return $memoryLimitValue;
}

function getPercentMemoryUsed() : int
{
    $maxMemory = memory_get_peak_usage();

    $memoryLimitValue = getMemoryLimit();

    $percentMemoryUsed = (int)((100 * $maxMemory) / $memoryLimitValue);

    return $percentMemoryUsed;
}


/**
 * @param mixed $needle
 * @param array<mixed> $haystack
 * @return bool
 */
function array_contains($needle, array $haystack): bool
{
    return in_array($needle, $haystack, true);
}


/**
 * @param string[] $headers
 * @param mixed[][] $rows
 * @return string
 */
function renderTable($headers, $rows)
{
    $thead = '';
    foreach ($headers as $header) {
        $thead .= sprintf("<th>%s</th>\n", $header);
    }

    $tbody = '';
    foreach ($rows as $row) {
        $tbody .= "<tr>\n";
        foreach ($headers as $key) {
            $value = $row[$key];
            $tbody .= sprintf("<td>%s</td>\n", $value);
        }

        $tbody .= "</tr>\n";
    }

    $table = <<< TABLE
<table>
  <thead>
    <tr>
     $thead
    </tr>
  </thead>
  <tbody>
    $tbody
  </tbody>
</table>
TABLE;


    return $table;
}



function randomPassword(int $length): string
{
    $characters = '0123456789abcdefghjkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ!@£$%^&*()/?{}[]';
    $charactersLength = mb_strlen($characters);
    $randString = '';

    for ($i = 0; $i < $length; $i++) {
        $offset = $charactersLength - 1;
        $position = random_int(0, $offset);
        $randString .= mb_substr($characters, $position, 1);
    }

    return $randString;
}

/**
 * @param array<mixed> $items
 * @param array<string> $headers
 * @param callable $rowFn
 * @return string
 */
function renderTableHtml($items, array $headers, callable $rowFn)
{
    $thead = '';
    foreach ($headers as $header) {
        $thead .= sprintf("     <th>%s</th>\n", $header);
    }

    $tbody = '';
    foreach ($items as $item) {
        $tbody .= $rowFn($item);
    }

    $table = <<< TABLE
<table>
  <thead>
    <tr>
$thead
    </tr>
  </thead>
  <tbody>
$tbody
  </tbody>
</table>
TABLE;

    return $table;
}


/**
 * @param Throwable $exception
 * @return mixed
 */
function getExceptionInfoAsArray(\Throwable $exception)
{
    $data = [
        'status' => 'error',
        'message' => $exception->getMessage(),
    ];

    $previousExceptions = [];

    do {
        $exceptionInfo = [
            'type' => get_class($exception),
            'message' => $exception->getMessage(),
            'trace' => getExceptionStackAsArray($exception),
        ];

        $previousExceptions[] = $exceptionInfo;
    } while (($exception = $exception->getPrevious()) !== null);

    $data['details'] = $previousExceptions;

    return $data;
}

/**
 * Format an array of strings to have a count at the start
 * e.g. $lines = ['foo', 'bar'], output is:
 *
 * #0 foo
 * #1 bar
 * @param array<string> $lines
 * @return string
 */
function formatLinesWithCount(array $lines): string
{
    $output = '';
    $count = 0;

    foreach ($lines as $line) {
        $output .= '  #' . $count . ' '. $line . "\n";
        $count += 1;
    }

    return $output;
}

function getRandomId(): string
{
    $foo = random_bytes(32);

    return hash("sha256", $foo);
}

function showTotalErrorPage(\Throwable $exception): void
{
    $exceptionText = "Failed to get exception text.";

    try {
        $exceptionText = getExceptionText($exception);

        \error_log("Exception in code and Slim error handler failed also: " . get_class($exception) . " " . $exceptionText);
    }
    catch (\Throwable $exception) {
        // Does nothing.
    }

    http_response_code(503);

    if ($exceptionText !== null) {
        var_dump(get_class($exception));
        echo nl2br($exceptionText);
    }
}

function createDefaultEditInfo(): EditInfo
{
    return new EditInfo(['Edit page' => 'https://github.com/PHPOpenDocs/PHPOpenDocs']);
}

function createDefaultCopyrightInfo(): CopyrightInfo
{
    return new CopyrightInfo(
        'PHP OpenDocs',
        'https://github.com/PHPOpenDocs/PHPOpenDocs/blob/main/LICENSE'
    );
}

function createErrorPage(string $errorContentsHtml): OpenDocs\Page
{
    return new OpenDocs\Page(
        'error',
        createDefaultEditInfo(),
        [],
        new OpenDocs\PrevNextLinks(null, null),
        $contentHtml = $errorContentsHtml,
        new OpenDocs\CopyrightInfo('PHPOpenDocs', 'https://github.com/PHPOpenDocs/PHPOpenDocs'),
        new Breadcrumbs(),
        null
    );
}

/**
 * Remove the installation directory prefix from a filename
 */
function normaliseFilePath(string $file): string
{
    if (strpos($file, "/var/app/") === 0) {
        $file = substr($file, strlen("/var/app/"));
    }

    return $file;
}

function convertPageToHtmlResponse(
    \OpenDocs\Section $section,
    \OpenDocs\Page $page
): HtmlResponse {
    $headerLinks = createStandardHeaderLinks();
    $breadcrumbs = new Breadcrumbs();

    $html = createPageHtml(
        $section,
        $page
    );

    return new HtmlResponse($html);
}


function createPHPOpenDocsEditInfo(string $description, string $file, ?int $line): EditInfo
{
    $path = normaliseFilePath($file);

    $link = 'https://github.com/PHPOpenDocs/PHPOpenDocs/blob/main/' . $path;

    if ($line !== null) {
        $link .= '#L' . $line;
    }

    return new EditInfo([$description => $link]);
}

function getSectionHtml(SectionList $sectionList): string
{
    $html = '';
    $sectionTemplate = "<a href=':attr_link'>:html_name</a><p>:html_description</p>";

    foreach ($sectionList->getSections() as $section) {
        $params = [
            ':attr_link' => $section->getPrefix(),
            ':html_name' => $section->getName(),
            ':html_description' => $section->getPurpose()
        ];
        $html .= esprintf($sectionTemplate, $params);
    }

    return $html;
}


/**
 * @param ContentPolicyViolationReport[] $reports
 */
function formatCSPViolationReportsToHtml(array $reports): string
{
    if (count($reports) === 0) {
        return 'There are no CSP violation reports. \o/';
    }

    $headers = [
        "document-uri",
        "blocked-uri",
        "violated-directive",
        "effective-directive"
    ];

    $data = [];
    foreach ($reports as $report) {
        $data[] = $report->toArray();
    }

    return renderTable($headers, $data);
}

/**
 * @param \OpenDocs\ContentLink[] $contentLinks
 * @param string $currentPosition
 * @return \OpenDocs\ContentLink|null
 */
function getPreviousLink(array $contentLinks, string $currentPosition):\OpenDocs\ContentLink|null
{
    $currentLink = null;

    // Loop forward through the links to find the previous link.
    foreach ($contentLinks as $link) {
        if ($link->getPath() === $currentPosition) {
            return $currentLink;
        }
        // a link is only clickable if the path of it is not null
        // aka avoid unclickable section headers
        if ($link->getPath() !== null) {
            $currentLink = $link;
        }
    }

    return null;
}

/**
 * @param \OpenDocs\ContentLink[] $contentLinks
 * @param string $currentPosition
 * @return \OpenDocs\PrevNextLinks
 */
function createPrevNextLinksFromContentLinks(
    array $contentLinks,
    string $currentPosition
) {

    $previousLink = getPreviousLink(
        $contentLinks,
        $currentPosition
    );

    // Loop backwards through the links to find the next link.
    $nextLink = getPreviousLink(
        array_reverse($contentLinks),
        $currentPosition
    );

    return new OpenDocs\PrevNextLinks($previousLink, $nextLink);
}

function createLinkInfo(string $currentPosition, array $contentLinks): OpenDocs\LinkInfo
{
    $prevNext = createPrevNextLinksFromContentLinks($contentLinks, $currentPosition);
    return new \OpenDocs\LinkInfo(
        $prevNext,
        $contentLinks,
    );
}


function mapOpenDocsPageToPsr7(
    \OpenDocs\Page $page,
    \Psr\Http\Message\ServerRequestInterface $request,
    ResponseInterface $response
): ResponseInterface {
    $html = createPageHtml(
        $page->getSection(),
        $page
    );

    $htmlResponse = new \SlimAuryn\Response\HtmlResponse($html);

    return mapStubResponseToPsr7(
        $htmlResponse,
        $request,
        $response
    );
}



function getAurynFixText(\Auryn\InjectionException $injectionException): string|null
{
    switch ($injectionException->getCode()) {
        case \Auryn\Injector::E_NEEDS_DEFINITION:
        {
            $type = $injectionException->getDependencyChain()[0];

            $rc = new ReflectionClass($type);
            $kind = "Not an interface or abstract class - that's odd.";

            if ($rc->isInterface()) {
                $kind = 'interface';
            }
            else if ($rc->isAbstract()) {
                $kind = 'abstract class';
            }
            $message = <<< TEXT
The type $type is a $kind and so can't be instantiated. You need to alias it to an instantiable class in the injector config. That would look something like:
<pre>

  \$injector->alias(
    $type::class,
    Foo$type::class
  );
</pre>
TEXT;

            return $message;
        }

//    \Auryn\Injector::E_NON_EMPTY_STRING_ALIAS
//    \Auryn\Injector::E_SHARED_CANNOT_ALIAS
//    \Auryn\Injector::E_SHARE_ARGUMENT
//    \Auryn\Injector::E_ALIASED_CANNOT_SHARE
//    \Auryn\Injector::E_INVOKABLE
//    \Auryn\Injector::E_NON_PUBLIC_CONSTRUCTOR
//
//    \Auryn\Injector::E_MAKE_FAILURE
//    \Auryn\Injector::E_UNDEFINED_PARAM
//    \Auryn\Injector::E_DELEGATE_ARGUMENT
//    \Auryn\Injector::E_CYCLIC_DEPENDENCY
//    \Auryn\Injector::E_MAKING_FAILED



        default:
            return null;
    }
}


function setupAllRoutes(\Slim\App $app): void
{
    $sectionList = createSectionList();
    foreach ($sectionList->getSections() as $section) {
        $sectionInfo = $section->getSectionInfo();
        foreach ($sectionInfo->getRoutes() as $route) {
            $fullPath = $section->getPrefix() . $route->getPath();
            $routeCallable = $route->getCallable();
            $slimRoute = $app->map([$route->getMethod()], $fullPath, $routeCallable);
        }
    }

    $routes = getAllRoutes();
    foreach ($routes as $standardRoute) {
        list($path, $method, $callable) = $standardRoute;
        $slimRoute = $app->map([$method], $path, $callable);
    }
}
