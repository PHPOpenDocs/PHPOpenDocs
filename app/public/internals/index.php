<?php

declare(strict_types = 1);

require_once __DIR__ . "/../../../src/web_bootstrap.php";

use Internals\InternalsSection;

use OpenDocs\BreadcrumbsFactory;
use OpenDocs\Page;
use function Internals\getInternalsContentLinks;
use function Internals\createInternalsDefaultCopyrightInfo;

function get_thomas_example_html()
{
    $thomas_example_descriptions = [
        'basic_skeleton' => null,
        'call_method' => null,
        'class' => null,
        'class_abstract' => null,
        'class_attach_struct' => null,
        'class_constant' => null,
        'class_implements_interface' => null,
        'class_method' => null,
        'class_property_public' => null,
        'constant' => null,
        'exception_own' => null,
        'exception_spl' => null,
        'function' => null,
        'function_arginfo' => null,
        'function_arginfo_object' => null,
        'function_arginfo_object_namespace' => null,
        'function_arginfo_with_return' => null,
        'function_argument_array' => null,
        'function_argument_callback' => null,
        'function_argument_mixed' => null,
        'function_argument_optional' => null,
        'function_argument_string' => null,
        'function_argument_variadics' => null,
        'function_return' => null,
        'function_return_array_assoc' => null,
        'function_return_array_numeric' => null,
        'function_return_new_object' => null,
        'function_return_new_stdclass' => null,
        'global_variable' => null,
        'interface' => null,
        'phpinfo' => null,
        'resource' => null,
    ];

    $thomas_example_entries = [];
    foreach ($thomas_example_descriptions as $name => $description) {
        $thomas_example_entries[] = sprintf(
            '<li><a href="https://github.com/ThomasWeinert/php-extension-sample/tree/%s">%s</a></li>',
            $name,
            $description ?? $name
        );
    }

    return "<ul>" . implode("\n", $thomas_example_entries) . "</ul>";
}


function get_dmitry_example_html()
{
//    Writing PHP Extensions
//1. Setting up Your PHP Build Environment on Linux
//2. Generating a PHP Extension Skeleton
//3. Building and Installing a PHP Extension
//4. Rebuilding Extensions for Production
//                             5. Extension Skeleton File Content
//6. Running PHP Extension Tests
//7. Adding New Functionality
//8. Basic PHP Structures
//9. PHP Arrays
//10. Catching Memory Leaks
//11. PHP Memory Management
//12. PHP References
//13. Copy on Write
//14. PHP Classes and Objects
//15. Using OOP in our Example Extension
//16. Embedding C Data into PHP Objects
//17. Overriding Object Handlers
//18. Answers to Common Extension Questions
//// https://github.com/dstogov/php-extension
////https://www.zend.com/resources/writing-php-extensions
}




$fn = function (
    InternalsSection $section,
    BreadcrumbsFactory $breadcrumbsFactory
) : Page {

    $thomas_example_html = get_thomas_example_html();

    $html  = <<< HTML
<h1>PHP internals info</h1>

<p>
Info about PHP Internal development.
</p>

<h2>Main resources</h2>

<h3>The PHP Internals Book</h3>

<p>
The <a href="http://www.phpinternalsbook.com/">PHP Internals Book</a> is the most comprehensive resource for learning how PHP works internally, and how the functionality can be updated. I'd recommend reading all of it, but here are a few choice articles which are pretty vital to read.
</p>

<ul>
  <li>
    <a href="https://www.phpinternalsbook.com/php7/extensions_design/php_lifecycle.html">Learning the PHP lifecycle</a>
  </li>
  <li>
    <a href="https://www.phpinternalsbook.com/php7/zvals.html">Zvals</a>
  </li>
  <li>
    <a href="https://www.phpinternalsbook.com/php7/memory_management/zend_memory_manager.html">Zend Memory Manager</a>
  </li>
</ul>

<h3>Nikita Popov's blog</h3>

<p>
  Nikic Popov <a href="https://www.npopov.com/">has a blog</a>. It's generally interesting, and has some quite in depth articles on PHP internals:
</p>

<ul>
  <li>
    <a href="https://www.npopov.com/2012/07/27/How-to-add-new-syntactic-features-to-PHP.html">
      How to add new (syntactic) features to PHP  
    </a>
  </li>
  <li>
    <a href="https://www.npopov.com/2014/12/22/PHPs-new-hashtable-implementation.html">PHP's new hashtable implementation</a>
  </li>
  <li>
    <a href="https://www.npopov.com/2017/04/14/PHP-7-Virtual-machine.html">PHP 7 Virtual Machine</a>
  </li>
</ul>


<h3>Julien Pauli's blog</h3>

On his blog, Julien Pauli has quite a few <a href="http://blog.jpauli.tech/tag/php/">in-depth posts about PHP</a>. He also has a presentation of how <a href="https://symfonycasts.com/screencast/symfonycon2019/a-view-in-the-php-virtual-machine">all the internal bits fit together.</a>


<h3>Sample implementation details</h3>

<p>
Thomas Weinert has a comprehensive example of <a href="https://github.com/ThomasWeinert/php-extension-sample">how to implement features in PHP internals</a>, where each branch implements a single feature. The way to use this set of examples is to find the branch that contains what you want to implement, check it out, and then look at the commits in that branch to see what was done.
</p>

$thomas_example_html

<h2>Other stuff</h2>

<h3>Debugging tools</h3>
<p>
  If you're writing C code, you have probably made a poor life choice somewhere, and as a result, you should learn how to use <a href="/learning/debugging/valgrind">valgrind</a> and <a href="/learning/debugging/gdb">GDB</a>.
</p>

<h3>M4</h3>
<p>
  M4 is a macro processor used to configure PHP and PHP extensions. It is <em>somewhat</em> non-intuitive to use, and you may find <a href="https://mbreen.com/m4.html">notes on the M4 Macro Language</a> useful. The fine <a href="https://www.gnu.org/software/m4/manual/html_node/index.html">M4 manual</a> itself is also possibly useful.
</p>


<h2>Etiquette and RFCs</h2>
<ul>
  <li>
    <a href='{$section->getPrefix()}/mailing_list'>Mailing list</a> - Mailing list etiquette.
  </li>

  <li>
    <a href='{$section->getPrefix()}/rfc_attitudes'>RFC attitudes</a> - understand the attitude the PHP internal participants take when evaluating RFCs.
  </li>
  
  <li>
    <a href='{$section->getPrefix()}/rfc_etiquette'>RFC Etiquette</a> - notes on etiquette surrounding RFCs.
  </li>
</ul>



<h2>Miscellaneous info</h2>


<h2>Generics</h2>

<p>
The feature most commonly desired in PHP is generics. People have been thinking about it for a while, and there is a <a href="https://github.com/PHPGenerics/php-generics-rfc/issues">discussion</a> about what would be required. In particular <a href="https://github.com/PHPGenerics/php-generics-rfc/issues/45">Nikic's notes on implementation</a> are probably of interest.
</p> 

<h2>Tests</h2>

The test suite used by PHP is well documented <a href="https://www.phpinternalsbook.com/tests/running_the_test_suite.html">in the PHP internals book</a> 

<ul>
  <li>Tests in parallel - From PHP 7.4, run-tests.php can accept a -jx parameter to run tests in parallel. This can significantly reduce the amount of time take to run either the PHP or extension test suite. e.g. `php run-tests.php -j4`
  </li>

  <li>Sub-set of tests - php run-tests.php ext/foo/tests</li>

  <li>Running with valgrind - php run-tests.php -m

</ul>

<h2>todo</h2>

<ul>
  <li>
    follow up on https://github.com/php/doc-en/pull/152 with CMB.
  </li>
  <li>
    https://wiki.php.net/internals/extensions
  </li>
  <li>
    evaluate writing extensions in Go. - https://github.com/kitech/php-go
  </li>
  <li>
    evaluate https://wiki.php.net/internals/references
  </li>
  <li>
    evaluate https://github.com/SammyK/php-internals-getting-started
  </li>
</ul>


HTML;

    $contentLinks = getInternalsContentLinks();

    $page = Page::createFromHtmlEx2(
        'Internals',
        $html,
        createPHPOpenDocsEditInfo('Edit page', __FILE__, null),
        $breadcrumbsFactory->createFromArray([]),
        createInternalsDefaultCopyrightInfo(),
        createLinkInfo('/', $contentLinks),
        $section
    );

    return $page;
};

showLearningResponse($fn);
