<?php

namespace Destruktiv\ForumBundle\Twig\Extension;

class MarkdownExtension extends \Twig_Extension
{
    /**
     * @var \Sundown\Markdown
     */
    private $markdown;


    public function __construct(\Sundown\Markdown $markdown)
    {
        $this->markdown = $markdown;
    }

    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter("markdown", [$this, "markdownFilter"]),
        ];
    }

    public function markdownFilter($text)
    {
        return $this->markdown->render($text);
    }

    public function getName()
    {
        return 'destruktiv_markdown_extension';
    }
}
