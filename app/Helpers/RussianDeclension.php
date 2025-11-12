<?php

namespace App\Helpers;

class RussianDeclension
{
    /**
     * Convert a phrase to prepositional (for use after "О").
     * Simple heuristic implementation; for high accuracy consider integrating phpMorphy or Morphos.
     */
    public static function toPrepositional(string $text): string
    {
        $text = trim($text);
        if ($text === '') {
            return $text;
        }

        // delimiters after which we keep the rest unchanged
        $delimiters = [
            ' для ', ' с ', ' со ', ' по ', ' на ', ' в ', ' под ', ' при ',
            ' без ', ' из ', ' от ', ' о ', ' об ', ' про ',
        ];

        $pos = false;
        $found = '';
        foreach ($delimiters as $del) {
            $i = mb_stripos($text, $del);
            if ($i !== false && ($pos === false || $i < $pos)) {
                $pos = $i;
                $found = mb_substr($text, $i, mb_strlen($del));
            }
        }

        if ($pos !== false) {
            $main = trim(mb_substr($text, 0, $pos));
            $rest = mb_substr($text, $pos);
        } else {
            $main = $text;
            $rest = '';
        }

        $words = preg_split('/\s+/u', $main);
        if (empty($words)) {
            return $text;
        }

        $last = array_pop($words);
        $prev = $words;

        // If the last word looks like an adjective, decline it as adjective; otherwise as noun.
        if (self::isLikelyAdjective($last)) {
            $declinedLast = self::declineAdjectiveToPrepositional($last);
        } else {
            $declinedLast = self::declineNounToPrepositional($last);
        }

        $declinedPrev = [];
        if (! empty($prev)) {
            foreach ($prev as $w) {
                $declinedPrev[] = self::declineAdjectiveToPrepositional($w);
            }
        }

        $resultMain = implode(' ', array_merge($declinedPrev, [$declinedLast]));

        // preserve capitalization of the first letter
        $firstOrig = mb_substr($text, 0, 1, 'UTF-8');
        if ($firstOrig === mb_strtoupper($firstOrig, 'UTF-8')) {
            $resultMain = mb_strtoupper(mb_substr($resultMain, 0, 1, 'UTF-8'), 'UTF-8')
                .mb_substr($resultMain, 1, null, 'UTF-8');
        }

        return trim($resultMain.$rest);
    }

    /**
     * Convert a phrase to genitive (for use after words like "Польза").
     */
    public static function toGenitive(string $text): string
    {
        $text = trim($text);
        if ($text === '') {
            return $text;
        }

        $delimiters = [
            ' для ', ' с ', ' со ', ' по ', ' на ', ' в ', ' под ', ' при ',
            ' без ', ' из ', ' от ', ' о ', ' об ', ' про ',
        ];

        $pos = false;
        $found = '';
        foreach ($delimiters as $del) {
            $i = mb_stripos($text, $del);
            if ($i !== false && ($pos === false || $i < $pos)) {
                $pos = $i;
                $found = mb_substr($text, $i, mb_strlen($del));
            }
        }

        if ($pos !== false) {
            $main = trim(mb_substr($text, 0, $pos));
            $rest = mb_substr($text, $pos);
        } else {
            $main = $text;
            $rest = '';
        }

        $words = preg_split('/\s+/u', $main);
        if (empty($words)) {
            return $text;
        }

        $last = array_pop($words);
        $prev = $words;

        // If the last word looks like an adjective, decline it as adjective; otherwise as noun.
        if (self::isLikelyAdjective($last)) {
            $declinedLast = self::declineAdjectiveToGenitive($last);
        } else {
            $declinedLast = self::declineNounToGenitive($last);
        }

        $declinedPrev = [];
        if (! empty($prev)) {
            foreach ($prev as $w) {
                $declinedPrev[] = self::declineAdjectiveToGenitive($w);
            }
        }

        $resultMain = implode(' ', array_merge($declinedPrev, [$declinedLast]));

        $firstOrig = mb_substr($text, 0, 1, 'UTF-8');
        if ($firstOrig === mb_strtoupper($firstOrig, 'UTF-8')) {
            $resultMain = mb_strtoupper(mb_substr($resultMain, 0, 1, 'UTF-8'), 'UTF-8')
                .mb_substr($resultMain, 1, null, 'UTF-8');
        }

        return trim($resultMain.$rest);
    }

    protected static function declineNounToPrepositional(string $word): string
    {
        // don't decline acronyms or short uppercase tokens
        if (self::isAcronym($word)) {
            return $word;
        }

        $w = mb_strtolower($word, 'UTF-8');

        if (mb_substr($w, -2) === 'ия') {
            $res = mb_substr($w, 0, mb_strlen($w, 'UTF-8') - 2, 'UTF-8').'ии';

            return self::matchCase($word, $res);
        }

        if (mb_substr($w, -2) === 'ие') {
            $res = mb_substr($w, 0, mb_strlen($w, 'UTF-8') - 2, 'UTF-8').'ии';

            return self::matchCase($word, $res);
        }

        if (mb_substr($w, -1) === 'а') {
            $res = mb_substr($w, 0, mb_strlen($w, 'UTF-8') - 1, 'UTF-8').'е';

            return self::matchCase($word, $res);
        }

        if (mb_substr($w, -1) === 'я') {
            $res = mb_substr($w, 0, mb_strlen($w, 'UTF-8') - 1, 'UTF-8').'е';

            return self::matchCase($word, $res);
        }

        if (mb_substr($w, -1) === 'ь') {
            $res = $w.'и';

            return self::matchCase($word, $res);
        }

        $last = mb_substr($w, -1);
        if (preg_match('/[бвгджзйклмнпрстфхцчшщ]$/u', $last)) {
            $res = $w.'е';

            return self::matchCase($word, $res);
        }

        $res = $w.'е';

        return self::matchCase($word, $res);
    }

    protected static function declineAdjectiveToPrepositional(string $word): string
    {
        if (self::isAcronym($word)) {
            return $word;
        }

        $w = mb_strtolower($word, 'UTF-8');

        // feminine endings
        if (mb_substr($w, -2) === 'ая') {
            $res = mb_substr($w, 0, mb_strlen($w, 'UTF-8') - 2, 'UTF-8').'ой';

            return self::matchCase($word, $res);
        }

        if (mb_substr($w, -2) === 'яя') {
            $res = mb_substr($w, 0, mb_strlen($w, 'UTF-8') - 2, 'UTF-8').'ей';

            return self::matchCase($word, $res);
        }

        // masculine/neuter patterns
        if (mb_substr($w, -2) === 'ый') {
            $res = mb_substr($w, 0, mb_strlen($w, 'UTF-8') - 2, 'UTF-8').'ом';

            return self::matchCase($word, $res);
        }

        if (mb_substr($w, -2) === 'ий') {
            // handle -кий -> -ком (плоский -> плоском), -ний/-тий -> -нем/-тем (синий -> синем)
            $stem = mb_substr($w, 0, mb_strlen($w, 'UTF-8') - 2, 'UTF-8');
            $prev = mb_substr($stem, -1, 1, 'UTF-8');

            if ($prev === 'к' || $prev === 'г' || $prev === 'х') {
                // -кий -> -ком (and similar hard consonants)
                // avoid doubling the consonant if stem already ends with it (плоск + ком -> плоском)
                $suffix = 'ком';
                $firstSuffix = mb_substr($suffix, 0, 1, 'UTF-8');
                if ($prev === $firstSuffix) {
                    $res = mb_substr($stem, 0, mb_strlen($stem, 'UTF-8') - 1, 'UTF-8').$suffix;
                } else {
                    $res = $stem.$suffix;
                }
            } else {
                // default for -ий -> -ем
                $res = $stem.'ем';
            }

            return self::matchCase($word, $res);
        }

        if (mb_substr($w, -2) === 'ой' || mb_substr($w, -2) === 'ом') {
            return $word;
        }

        $res = $w.'ом';

        return self::matchCase($word, $res);
    }

    protected static function declineAdjectiveToGenitive(string $word): string
    {
        if (self::isAcronym($word)) {
            return $word;
        }

        $w = mb_strtolower($word, 'UTF-8');

        // -кий -> -кого (плоский -> плоского)
        if (mb_substr($w, -3) === 'кий') {
            // keep the 'к' in the stem, remove only 'ий' so we get 'плоск' + 'ого' -> 'плоского'
            $stem = mb_substr($w, 0, mb_strlen($w, 'UTF-8') - 2, 'UTF-8');
            $res = $stem.'ого';

            return self::matchCase($word, $res);
        }

        if (mb_substr($w, -2) === 'ый') {
            $res = mb_substr($w, 0, mb_strlen($w, 'UTF-8') - 2, 'UTF-8').'ого';

            return self::matchCase($word, $res);
        }

        if (mb_substr($w, -2) === 'ий') {
            $res = mb_substr($w, 0, mb_strlen($w, 'UTF-8') - 2, 'UTF-8').'его';

            return self::matchCase($word, $res);
        }

        // default fallback: use prepositional heuristic
        return self::declineAdjectiveToPrepositional($word);
    }

    /**
     * Heuristic: determine whether a word is likely an adjective.
     * Very simple: check for common adjective endings.
     */
    protected static function isLikelyAdjective(string $word): bool
    {
        $w = mb_strtolower(trim($word, ",.()[]{}\"'«»"), 'UTF-8');
        // common adjective endings: -ый, -ая, -ое, -ий, -ая, -яя, -ой, -яя, -кая, -кий
        $end2 = mb_substr($w, -2);
        $end3 = mb_substr($w, -3);

        $adjectiveEnds2 = ['ый', 'ая', 'ое', 'ий', 'ой', 'ем', 'ом'];
        $adjectiveEnds3 = ['кий', 'ная'];

        if (in_array($end2, $adjectiveEnds2, true) || in_array($end3, $adjectiveEnds3, true)) {
            return true;
        }

        return false;
    }

    protected static function declineNounToGenitive(string $word): string
    {
        if (self::isAcronym($word)) {
            return $word;
        }

        $w = mb_strtolower($word, 'UTF-8');

        if (mb_substr($w, -2) === 'ия') {
            $res = mb_substr($w, 0, mb_strlen($w, 'UTF-8') - 2, 'UTF-8').'ии';

            return self::matchCase($word, $res);
        }

        if (mb_substr($w, -2) === 'ие') {
            // знание -> знания
            $res = mb_substr($w, 0, mb_strlen($w, 'UTF-8') - 1, 'UTF-8').'я';

            return self::matchCase($word, $res);
        }

        if (mb_substr($w, -1) === 'я') {
            // nouns ending with 'я' -> replace with 'и' (неделя -> недели)
            $res = mb_substr($w, 0, mb_strlen($w, 'UTF-8') - 1, 'UTF-8').'и';

            return self::matchCase($word, $res);
        }

        if (mb_substr($w, -1) === 'а') {
            // nouns ending with 'а' usually take 'ы' in genitive, except after the "7 letters" (г,к,х,ж,ч,ш,щ) -> use 'и'
            $stem = mb_substr($w, 0, mb_strlen($w, 'UTF-8') - 1, 'UTF-8');
            $prevChar = mb_substr($stem, -1, 1, 'UTF-8');
            if (preg_match('/[гкхжчшщ]/u', $prevChar)) {
                $ending = 'и';
            } else {
                $ending = 'ы';
            }
            $res = $stem.$ending;

            return self::matchCase($word, $res);
        }

        if (mb_substr($w, -1) === 'ь') {
            // many nouns: add 'и' (мать -> матери)
            $res = $w.'и';

            return self::matchCase($word, $res);
        }

        if (mb_substr($w, -1) === 'о' || mb_substr($w, -1) === 'е') {
            // neuter -> replace with 'а'
            $res = mb_substr($w, 0, mb_strlen($w, 'UTF-8') - 1, 'UTF-8').'а';

            return self::matchCase($word, $res);
        }

        // default: masculine consonant -> add 'а'
        $res = $w.'а';

        return self::matchCase($word, $res);
    }

    protected static function matchCase(string $orig, string $new): string
    {
        $firstOrig = mb_substr($orig, 0, 1, 'UTF-8');
        if ($firstOrig === mb_strtoupper($firstOrig, 'UTF-8')) {
            return mb_strtoupper(mb_substr($new, 0, 1, 'UTF-8'), 'UTF-8').mb_substr($new, 1, null, 'UTF-8');
        }

        return $new;
    }

    /**
     * Detect simple acronyms (Latin or Cyrillic uppercase, 2+ letters or containing digits).
     */
    protected static function isAcronym(string $word): bool
    {
        // strip surrounding punctuation
        $w = trim($word, ",.()[]{}\"'«»");

        // Latin uppercase (2+ letters) or digits
        if (preg_match('/^[A-Z0-9]{2,}$/u', $w)) {
            return true;
        }

        // Cyrillic uppercase (2+ letters) including Ё
        if (preg_match('/^[А-ЯЁ0-9]{2,}$/u', $w)) {
            return true;
        }

        return false;
    }
}
