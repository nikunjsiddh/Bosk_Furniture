<?php
/* ============================================================
   Bosk Furniture — FAQ extraction for FAQPage structured data.

   Google requires FAQPage markup to match the answer text visible on
   the page character for character. So rather than storing the FAQ
   separately (where the two copies would drift), the pairs are parsed
   back out of the post body that is actually rendered.

   Recognised shape, as used by the blog posts:

       FAQ

       Q: How is modular kitchen cost calculated?
       A: Usually by cabinet running feet ...

   Returns [] when the post has no FAQ block, so the caller simply
   emits no FAQPage node.
   ============================================================ */

if (!function_exists('bosk_parse_faq')) {
    function bosk_parse_faq($body) {
        $text = strip_tags((string)$body);
        if ($text === '' || stripos($text, 'Q:') === false) {
            return [];
        }

        $lines = preg_split('/\R/', $text);
        $pairs = [];
        $cur_q = null;
        $cur_a = '';

        $flush = function () use (&$pairs, &$cur_q, &$cur_a) {
            if ($cur_q !== null && trim($cur_a) !== '') {
                $pairs[] = ['q' => trim($cur_q), 'a' => trim($cur_a)];
            }
            $cur_q = null;
            $cur_a = '';
        };

        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '') { continue; }

            if (preg_match('/^Q\s*[:.\)]\s*(.+)$/i', $line, $m)) {
                $flush();
                $cur_q = $m[1];
            } elseif (preg_match('/^A\s*[:.\)]\s*(.+)$/i', $line, $m)) {
                if ($cur_q !== null) { $cur_a = $m[1]; }
            } elseif ($cur_q !== null && $cur_a !== '') {
                // Answer wrapped onto a following line.
                $cur_a .= ' ' . $line;
            }
        }
        $flush();

        return $pairs;
    }
}
