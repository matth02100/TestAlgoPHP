<?php
$time_start = microtime(true);

// Each all words for count occurrences
$countedWords = [];
foreach(str_word_count(strtolower(file_get_contents(__DIR__.'/content.txt')), 1) as $word) {
    $countedWords[$word] = !isset($countedWords[$word]) ? 1 : $countedWords[$word] + 1;
}

// Sort data
uasort($countedWords, static function($a, $b) {
    if ($a === $b) {
        return 0;
    }

    return ($a < $b) ? 1 : -1;
});

// Display results
echo '------------- Results -------------'.chr(10);
$countResult = 1;
foreach ($countedWords as $word => $count) {
    if(strlen($word) > 3){
        echo sprintf('%s - %d'."\n\r", $word, $count);
        if (++$countResult > 10) {
            break;
        }

        continue;
    }
}

echo '-----------------------------------'.chr(10).chr(10);

$time_end = microtime(true);
$time = $time_end - $time_start;

// Display statistics
echo '-------------- Stats --------------'.chr(10);
echo 'Peak Memory: '.number_format(memory_get_peak_usage(true)/1048576, 0, '.', ' ').'Mb'.chr(10);
echo 'Durée: '.round($time,3).' secondes'.chr(10);
echo '-----------------------------------'.chr(10);
