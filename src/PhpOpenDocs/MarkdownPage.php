<?php

declare(strict_types = 1);

namespace PhpOpenDocs;

use Michelf\Markdown;

class MarkdownPage
{
    private string $filename;

    private string $content_html;

    public function __construct(string $filename)
    {
        $this->filename = $filename;
        $markdown = @file_get_contents($this->filename);
        if ($markdown === false) {
            throw new \Exception("Failed to read $filename.");
        }

        $this->content_html = Markdown::defaultTransform($markdown);
    }


    public function getPageContent(): string
    {
        return $this->content_html;
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
<div id="breadcrumbs-inner">
 
  <ul>
    <li><a href="index.php">PHP Manual</a></li>      <li><a href="funcref.php">Function Reference</a></li>      <li><a href="refs.basic.vartype.php">Variable and Type Related Extensions</a></li>      <li><a href="book.funchand.php">Function Handling</a></li>      <li><a href="ref.funchand.php">Function handling Functions</a></li>      </ul>
</div>
HTML;

        return $html;
    }

    public function getPrevNextLinks(): string
    {
        $html = <<< HTML
 <div class="next">
    <a href="function.func-num-args.php">
      func_num_args »
    </a>
  </div>
  <div class="prev">
    <a href="function.func-get-arg.php">
      « func_get_arg        </a>
  </div>
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
