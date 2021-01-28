<?php

declare(strict_types = 1);

namespace NamingThings;

use OpenDocs\Breadcrumb;
use OpenDocs\Breadcrumbs;
use OpenDocs\ContentLinkLevel1;
use OpenDocs\ContentLinkLevel2;
use OpenDocs\ContentLinks;
use OpenDocs\CopyrightInfo;
use OpenDocs\GetRoute;
use OpenDocs\Page;
use OpenDocs\PrevNextLinks;
use OpenDocs\Section;

class Pages
{
    public function getNounsPage(): Page
    {
        $nouns = require(__DIR__ . "/nouns.php");

        $contents = renderNouns($nouns);

        return new Page(
            'Naming things - nouns',
            createEditInfo2(
                'Edit page', __FILE__, __LINE__,
                'Edit nouns', __DIR__ . "/nouns.php", null
            ),
            $this->getContentLinks(),
            new PrevNextLinks(null, null),
            $contents,
            new CopyrightInfo('Danack', 'https://github.com/Danack/RfcCodex/blob/master/LICENSE'),
            $breadcrumbs = new Breadcrumbs(
                new Breadcrumb('/nouns', 'Nouns'),
            )
        );
    }

    public function getVerbsPage(): Page
    {
        $verbs = require(__DIR__ . "/verbs.php");

        $contents = renderVerbs($verbs);

        return new Page(
            'Naming things - verbs',
            createEditInfo2(
                'Edit page', __FILE__, __LINE__,
                'Edit verbs', __DIR__ . "/verbs.php", null
            ),
            $this->getContentLinks(),
            new PrevNextLinks(null, null),
            $contents,
            new CopyrightInfo('Danack', 'https://github.com/Danack/RfcCodex/blob/master/LICENSE'),
            $breadcrumbs = new Breadcrumbs(
                new Breadcrumb('/verbs', 'Verbs'),
            )
        );
    }

    public function getIndexPage(Section $section): Page
    {
        $words = <<< HTML

<h1>Naming all the things</h1>

<p>
So, it turns out that naming things is hard. This section attempts to provide some example names for verbs and nouns to be used in your code and some 'standard' meaning for them. 
</p>

<p>
The word 'standard' is in quotes because these are just guidelines. They absolutely should not be taken as universal rules that must be followed.
</p>

<p>
  <a href=":attr_nouns_link">Nouns</a> - a list of verbs of nouns and the 'standard' thing that they would do. They are useful for choosing names for classes.
</p>

<p>
  <a href=":attr_verbs_link">Verbs</a> - a list of verbs and the 'standard' behaviour that most programmers would expect from them. These are useful for choosing the names for functions and class methods.
</p>

<p>
Please note these suggestions are for naming things in terms that <em>programmers</em> would understand. For code that is dealing with business problems, you should probably use domain specific names that non-programmers would understand. 
</p>


<h2>Some other resources</h2>
<p>
    <ul>
      <li>A paper describing
    <a href="https://www.nr.no/en/nrpublication?query=/file/sle2008_postproceedings.pdf">The Java Programmer’s Phrase BookEinar W. Høst and Bjarte M. Østvold</a> and the <a href="http://phrasebook.nr.no/phrasebook/index.html">Phrasebook itself</a>
      </li>
    
      <li>
        <a href="https://blog.joda.org/2011/08/common-java-method-names.html">Common Java method names</a> by Stephen Colebourne
      </li>
    
      <li>
        <a href="http://chrisoldwood.blogspot.com/2009/11/standard-method-name-verb-semantics.html">
    Standard Method Name Verb Semantics</a> by Chris Oldwood
    </li>
    
      <li>
        <a href="https://gist.github.com/maxtruxa/b2ca551e42d3aead2b3d">Antonym List</a> by maxtruxa
      </li>
      
      <li>
        <a href="http://source-code-wordle.de/">Words used in Source Code</a> by Markus Meyer
      </li>
      
      
    </ul>
</p>

HTML;

        $params = [
            ':attr_verbs_link' => $section->getPrefix() . '/verbs',
            ':attr_nouns_link' => $section->getPrefix() . '/nouns',
        ];

        $contents = esprintf($words, $params);

        return new Page(
            'Naming things',
            createEditInfo('Edit page', __FILE__, __LINE__ - 33),
            $this->getContentLinks(),
            new PrevNextLinks(null, null),
            $contents,
            new CopyrightInfo('Danack', 'https://github.com/Danack/RfcCodex/blob/master/LICENSE'),
            $breadcrumbs = new Breadcrumbs()
        );
    }

    public function getContentLinks(): ContentLinks
    {
        $nouns = new ContentLinkLevel1(
            "/nouns",
            "Nouns",
            null
        );

        $verbs = new ContentLinkLevel1(
            "/verbs",
            "Verbs",
            null
        );

        return new ContentLinks([$nouns, $verbs]);
    }
}
