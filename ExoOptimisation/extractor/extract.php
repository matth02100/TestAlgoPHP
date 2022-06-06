<?php
// Stats time and memory
$time_start = microtime(true);

// Script
$text = file_get_contents('content.txt');

// extract words by spaces
$wordsExploded = explode(' ', $text);
$words = array();

// Each all words
foreach($wordsExploded as $word){
    // extract subword when it have a new line separator
    $subwords =  explode("\n", $word);

    // Each all words
    foreach($subwords as $w){
        // Remove punctuation
        $trimed = trim(trim($w, '.'),',');
        if(!empty($trimed))
            $words[] = $trimed;
    }
}

// Each all words for count occurrences
$results = array();
$total = 0;
foreach($words as $word){
    $found = false;

    // Search the word
    foreach($results as $k => $res){
        if($res['word'] == strtolower($word))
            $found = $k;
    }

    // Count it
    if($found === false) {
        $results[] = array(
            'word'  => strtolower($word),
            'count' => 1
        );
    }else {
        $results[$found]['count']++;
    }
    $total++;
}

// Sort datas
$while = true;
$change = 0;
$total = count($results);
$k = 0;
while($while){
    if($k+1 == $total){
        // no change array is sorted !
        if($change == 0)
            $while = false;

        $change = 0;
        $k = 0;
    }

    // Invert if needed !
    if($results[$k]['count'] < $results[$k+1]['count']){
        $prev = $results[$k];
        $next = $results[$k+1];

        // Invertion
        $results[$k+1] = $prev;
        $results[$k] = $next;

        $change++;
    }
    $k++;
}

// Display results
echo '------------- Results -------------'.chr(10);
$count = 0;
$i = 0;
while($count < 10){
    if(strlen($results[$i]['word']) > 3){
        echo $results[$i]['word'].' - '.$results[$i]['count'].chr(10);
        $count++;
    }
    $i++;
}
echo '-----------------------------------'.chr(10).chr(10);

$time_end = microtime(true);
$time = $time_end - $time_start;

// Display statistics
echo '-------------- Stats --------------'.chr(10);
echo 'Peak Memory: '.number_format(memory_get_peak_usage(true)/1048576, 0, '.', ' ').'Mb'.chr(10);
echo 'Durée: '.round($time,3).' secondes'.chr(10);
echo '-----------------------------------'.chr(10);