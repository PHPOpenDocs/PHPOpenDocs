<?php

declare(strict_types = 1);

namespace NamingThings;

use OpenDocs\EditInfo;

function createEditInfo(string $description, string $file, ?int $line): EditInfo
{
    $path = normaliseFilePath($file);

    $link = 'https://github.com/PHPOpenDocs/PHPOpenDocs/blob/main/' . $path;

    if ($link !== null) {
        $link .= '#L' . $line;
    }

    return new EditInfo([$description => $link]);
}

function createEditInfo2(
    string $description1,
    string $file1,
    ?int $line1,
    string $description2,
    string $file2,
    ?int $line2
): EditInfo {
    $path = normaliseFilePath($file1);
    $link1 = 'https://github.com/PHPOpenDocs/PHPOpenDocs/blob/main/' . $path;
    if ($line1 !== null) {
        $link1 .= '#L' . $line1;
    }

    $path = normaliseFilePath($file2);
    $link2 = 'https://github.com/PHPOpenDocs/PHPOpenDocs/blob/main/' . $path;
    if ($line2 !== null) {
        $link2 .= '#L' . $line2;
    }

    return new EditInfo([$description1 => $link1, $description2 => $link2]);
}


function noun_link(string $noun): string
{
    return "<a href='/naming/nouns#" . $noun . "'>" . $noun . "</a>";
}

function verb_link(string $verb): string
{
    return "<a href='/naming/verbs#" . $verb . "'>" . $verb . "</a>";
}



/**
 * @param Noun[] $nouns
 * @return string
 */
function renderNouns(array $nouns): string
{
    $content = <<< HTML
<h1>Common nouns for types</h1>

<p>
  Naming things is hard. Below is a list of nouns that can be used as names for types (aka classes in PHP) with  with descriptions of how the thing they commonly represent. The list should be considered more what you'd call <em>guidelines</em> than actual rules.
</p>
HTML;

    $content .= "<table class='nouns_table'><tbody>";

    $verb_template = <<< HTML
<tr>
  <td>
    <a class='anchor' href="#:attr_noun_name" id=":attr_noun_name">:html_noun_name</a>
  </td>
  <td class="nouns_see_also_wide_penultimate_cell">
    :raw_description
  </td>
  <td>
    :html_see_also
  </td>
</tr>
HTML;

    foreach ($nouns as $noun) {
        $params = [
            ':attr_noun_name' => $noun->getName(),
            ':html_noun_name' => $noun->getName(),
            ':raw_description' => $noun->getDescription(),
            ':html_see_also' => implode(',', $noun->getAlso())
        ];

        $content .= esprintf($verb_template, $params);
    }

    $content .= '</tbody></table>';

    return $content;
}

function getVerbSeeAlsoLinks(array $alsos): string
{
    $links = [];
    foreach ($alsos as $also) {
        $links[] = verb_link($also);
    }

    return implode(',', $links);
}


function getVerbSeeAlsoLinksNarrow(array $alsos): string
{
    if (count($alsos) === 0) {
        return '';
    }
    $links = [];
    foreach ($alsos as $also) {
        $links[] = verb_link($also);
    }

    return "See also " . implode(',', $links);
}


/**
 * @param Verb[] $verbs
 * @return string
 */
function renderVerbs(array $verbs): string
{
    $content = "";

    $content .= <<< HTML

<h1>Common verbs for function / method names</h1>

<p>
  Naming things is hard. Below is a list of verbs that can be used as names for either functions or class methods with descriptions of how they commonly behave. The list should be considered more what you'd call <em>guidelines</em> than actual rules.
</p>

<h2>Good names</h2>

<table class='verbs_table'>
  <thead>
    <tr>
      <th >Name</th>
      <th>Description</th>
      <th class="verbs_see_also_wide_display">See also</th>    
    </tr>  
  </thead>
HTML;

    $content .= "<tbody>";

    $verb_template = <<< HTML
<tr>
  <td>
    <div>
      <a class='anchor' href="#:attr_verb_name" id=":attr_verb_name">:html_verb_name</a>
    </div>
    
    <div class="verbs_see_also_wide_hide">
      :raw_see_also_narrow
    </div>
  </td>
  <td class="verbs_see_also_wide_penultimate_cell">
    :raw_description
  </td>
  <td class="verbs_see_also_wide_display">
    :raw_see_also
  </td>
</tr>
HTML;

    foreach ($verbs as $verb) {
        $params = [
            ':attr_verb_name' => $verb->getName(),
            ':html_verb_name' => $verb->getName(),
            ':raw_description' => $verb->getDescription(),
            ':raw_see_also_narrow' => getVerbSeeAlsoLinksNarrow($verb->getAlso()),
            ':raw_see_also' => getVerbSeeAlsoLinks($verb->getAlso()) //implode(',', $verb->getAlso())
        ];

        $content .= esprintf($verb_template, $params);
    }

    $content .= '</tbody></table>';

    $bad_functions = <<< HTML

<h2>Bad names</h2>

Maybe we should have a list of bad names here e.g. 'make'... is that 'create' or is it 'execute'?
HTML;

    $content .= $bad_functions;

    return $content;
}


function Noun(
    string $name,
    string $description,
    array $also = []
): Noun {
    return new Noun(
        $name,
        $description,
        $also
    );
}

function Verb(
    string $name,
    string $description,
    array $also = []
): Verb {
    return new Verb(
        $name,
        $description,
        $also
    );
}
