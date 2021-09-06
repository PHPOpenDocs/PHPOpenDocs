<?php

declare(strict_types = 1);

require_once __DIR__ . "/../../src/web_bootstrap.php";

use Merch\MerchSection;
use OpenDocs\BreadcrumbsFactory;
use OpenDocs\Page;
use OpenDocs\Breadcrumbs;

$fn = function (
    MerchSection $section,
    BreadcrumbsFactory $breadcrumbsFactory
) : Page {

    $html  = <<< HTML
<h1>Merch</h1>
  <span class="merch">
  
    
    <span class="merch_item">
      <h2>Elephpants</h2>
      
        <a href="https://www.elephpant.com/">
          <img src="/images/merch/Elephpants_small.jpeg" alt="Plush elephpants" style="clear: none">
        </a>
        <p>
        The ElePHPant is the adorable, elephantine mascot of the PHP project. You may have seen pictures of them (from <a href="https://www.flickr.com/groups/elephpants/">Flickr</a>) at the bottom of the php.net homepage. Beware of imitators. They are available in <a href="https://www.vincentpontier.com/elephpant/produit/elephpant-pink-original/">Pink</a> and <a href="https://www.vincentpontier.com/elephpant/produit/elephpant-blue-original/">Blue</a>.
      </p>
      
      <p>
Conferences and companies sometimes have custom Elephpants produced. <a href="https://afieldguidetoelephpants.net/">A Field Guide to Elephpants</a> - Detailing the attributes, habitats, and variations of the Elephpas hypertextus.
      </p>
    </span>
       
    <span>
      <h2>Mjölnir</h2>
      <p>When you wield PHP, you wield an ancient power...</p>
      
        <a href="https://cool-stuff-4-phpeeps.creator-spring.com/listing/php-thor-mjolnir-2?product=659">
  <img src="images/merch/Mjölnir2_mug_small.jpeg" alt="cool mug" />
  Mug
        </a>
        <a href="https://cool-stuff-4-phpeeps.creator-spring.com/listing/php-thor-mjolnir-2?product=790&variation=103520&size=4455">
          <img src="images/merch/Mjölnir2_tshirt_small.jpeg" alt="cool mug" />
T-shirt
        </a>
    </span>
    <span>
      <h2>Made in production t-shirts</h2>
      <p>
        <a href="https://madeinproduction.com/collections/t-shirts/products/doubleclaw-tshirt">
          <img src="/images/merch/Respect_the_double_claw_small.png" alt="a double clawed hammer">
        Respect the Double Claw Tshirt
        </a>
      </p>
    </span>
  </span>

<p>None of the links are affiliated with PHPOpenDocs. I just like them.</p>

HTML;

    $page = Page::createFromHtmlEx(
        'PHP Merch',
        $html,
        createPHPOpenDocsEditInfo('Edit page', __FILE__, null),
        Breadcrumbs::fromArray([
            '/merch' => 'Merch',
        ])
    );

    return $page;
};

showLearningResponse($fn);
