<?php

namespace App\Services;

class HtmlRenderService
{
    private $paired_tags = ['pre', 'code', 'b', 'i', 'u', 'p'];
    private $singular_tags = ['br'];

    public function replaceAllowedTags(string $content): string
    {
        $regexp_patterns = [];
        $regexp_replacement = [];
        $content = htmlspecialchars($content, ENT_NOQUOTES | ENT_HTML5, 'UTF-8', false);

        foreach ($this->paired_tags as $tag) {
            $regexp_patterns[] = '/&lt;' . $tag . '(.*?)&gt;(.*?)&lt;\/' . $tag . '&gt;/is';
            $regexp_replacement[] = '<' . $tag . '$1>$2</' . $tag . '>';
        }

        foreach ($this->singular_tags as $tag) {
            $regexp_patterns[] = '/&lt;' . $tag . '(.*?)\/?&gt;/is';
            $regexp_replacement[] = '<' . $tag . '$1>';
        }

        return preg_replace($regexp_patterns, $regexp_replacement, $content);
    }
}
