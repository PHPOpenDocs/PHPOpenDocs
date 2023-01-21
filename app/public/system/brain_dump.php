<?php

declare(strict_types = 1);

require_once __DIR__ . "/../../../src/web_bootstrap.php";

use OpenDocs\Breadcrumbs;
use SlimAuryn\Response\HtmlResponse;

$html  = <<< HTML

<h2>Brain dump</h2>

<p>So......I've been thinking about things. Some of those things are "why doesn't PHP have a general website other than the manual" and also "supporting the manual is terrible".</p>
<p>This is a brain dump of some of those thoughts, as apparently I am finding it difficult to write cohesive documents.</p>

<h3>Problem: editing any doc format other than markdown is more effort than most people can muster</h3>
<p>As much as I use the PHP manual, and would like other people to contribute to it, I find it hard to either edit it myself, or tell people 'hey you should edit it!' as it's.....just a bit annoying.</p>

<p><b>Solution</b>: make most of the content be in markdown.</p>

<h3>Problem: conversations don't scale</h3>
<p>Conversations online are kind of terrible...in particular conversations about curating content are inevitably terrible.</p>

<p>But also as the size of any community grows, the chances that at least one of the people in it is annoying also grows. It is not possible to implement a code of conduct that prevents assholes from being assholes, without a huge ongoing amount of effort. But it is possible to deliberately keep communities (and so communication) separate, so that an asshole in one particular community, only affects that community, rather than borking a whole project.</p>

<p><b>Solution</b>: avoid the need to have conversations scale. It's better to have only a few people who are interested in a particular topic be in charge of that topic, rather than them having to take feedback from everyone involved.</p>

<h3>Problem: Managing a website is boring</h3>
<p><b>Solution</b>: separate out the running the website from the content creation. In particular, people are fine with creating file in markdown, or other simple formats. If I can tell someone, "what you just gave a talk about was really great, you should write it as a document and I'll host it for you", that's more like to have something useful created, than if they have to deploy a whole website.</p>

<h3>Problem: People grow bored of managing content</h3>
<p>It's a common pattern for people to be enthusiastic about the tech they use, but then when they switch to working mostly in another language, it's probable they will lose enthusiasm for the first tech.</p>

<p>This becomes a problem when docuements need updating</p>

<p><b>Solution:</b> Make it easy to fork content, and have the website be able to switch to the new version.</p>

<h3>Problem: sites rot, sites diverge</h3>
<p>A couple of the websites that I used to visit, including pretty much all Java documentation, seems to be vanishing from the net. Without the source of that content, it's not possible for other people to host that content.</p>

<p>Separately, the needs of the Symfony/Laravel people might be quite different from the needs of people who don't use those frameworks. They would want some content on a general PHP website that would be inappropriate for non-Symfony/Laravel people, and vice-versa.</p>

<p><b>Solution:</b> Have all the content be distributed, in re-usable formats, it means that either when I grow bored of running this site, or people decide I'm doing a shite job, they can make a new site, that focuses on their needs more specifically, rather than trying to persuade me to keep an individual site running.</p>

<p>btw at some point I'll consider giving control over subdomains on this site (e.g. symfony.phpopendocs.com) to people who ask nicely for them.</p>

HTML;

$page = \OpenDocs\Page::createFromHtmlEx(
    'System',
    $html,
    createPhpOpenDocsEditInfo('Edit page', __FILE__, null),
    Breadcrumbs::fromArray(['/system/brain_dump' => 'Brain dump'])
);


showPage($page);