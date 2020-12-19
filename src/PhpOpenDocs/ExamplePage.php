<?php

declare(strict_types = 1);

namespace PhpOpenDocs;

class ExamplePage
{
    public function getPageContent(): string
    {
        $html = <<< HTML

<h2>
  Hello, I am the page content.
</h2>

<p>
This is a place holder page, that has all the bits filled out, so I can play with the SCSS. Maybe click on the sections.
</p>

<p>
Lets have some Lorem ipsum to fill out the page a bit. And test if the auto-deployer is working.
</p>

<p>
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam lacinia quam quis est ultrices vehicula. Nulla et sagittis eros. Etiam aliquet justo sit amet cursus volutpat. Fusce et ipsum vel quam commodo dapibus. Nullam vitae urna elit. Vivamus placerat odio molestie sapien facilisis, et venenatis ante fermentum. Suspendisse hendrerit sit amet ex ut ornare. Suspendisse porta arcu vitae elit tristique condimentum vitae in tortor. Fusce molestie sapien vel est interdum, et aliquet nunc vestibulum. Nam efficitur tempus libero sit amet rhoncus. Nulla facilisi.
</p>


HTML;

        return $html;
    }

    public function getRawTopHeader(): string
    {
        $html = <<< HTML
    <ul>
      <li><a href="/foo">Downloads</a></li>
      <li><a href="/bar">Documentation</a></li>
      <li><a href="/about">About</a></li>
    </ul>
HTML;
        return $html;
    }

    public function getBreadCrumbRaw(): string
    {
        $html = <<< HTML
  <ul>
    <li><a href="index.php">PHP Manual</a></li>      <li><a href="funcref.php">Function Reference</a></li>      <li><a href="refs.basic.vartype.php">Variable and Type Related Extensions</a></li>      <li><a href="book.funchand.php">Function Handling</a></li>      <li><a href="ref.funchand.php">Function handling Functions</a></li></ul>
HTML;

        return $html;
    }

    public function getPrevNextLinks(): string
    {
        $html = <<< HTML
 
  <span class="prev">
    <a href="function.func-get-arg.php">
      « func_get_arg
      </a>
  </span>


  <span class="next">
    <a href="function.func-num-args.php">
      func_num_args »
    </a>
  </span>

HTML;

        return $html;
    }


    public function getNavContent(): string
    {

        $html = <<< HTML

<ul class="parent-menu-list">
  <li>
    <a href="ref.funchand.php">Function handling Functions</a>

    <ul class="child-menu-list">

      <li class="">
        <a href="function.call-user-func-array.php" title="call_​user_​func_​array">call_​user_​func_​array</a>
      </li>
      <li class="">
        <a href="function.call-user-func.php" title="call_​user_​func">call_​user_​func</a>
      </li>
      <li class="">
        <a href="function.forward-static-call-array.php" title="forward_​static_​call_​array">forward_​static_​call_​array</a>
      </li>
      <li class="">
        <a href="function.forward-static-call.php" title="forward_​static_​call">forward_​static_​call</a>
      </li>
    </ul>
  </li>

  <li>
    <span class="header">Deprecated</span>
    <ul class="child-menu-list">
      <li class="">
        <a href="function.create-function.php" title="create_​function">create_​function</a>
      </li>
    </ul>
  </li>
</ul>
HTML;

        return $html;
    }


    public function getFooter(): string
    {
        $html = <<< HTML
<span class="copyright">Copyright © 2020 :html_copyright_name</span>
<span class="edit_link">
  <a href=":attr_edit_link">Edit this page</a>
</span>
HTML;

        $params = [
            ':html_copyright_name' => 'Danack',
            ':attr_edit_link' => 'https://github.com/PHPOpenDocs/Site/foo.php'
        ];

        return esprintf($html, $params);
    }
}
