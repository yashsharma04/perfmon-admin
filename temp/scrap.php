<?php
$file = fopen('na.csv', 'r');
$fp = fopen('result.csv', 'w');
while (($line = fgetcsv($file)) !== FALSE) {
    /*//echo $line[0]."<br>";
    $url = 'http://www.geonames.org/search.html?q='.$line[0];
    $html = file_get_contents($url);
    $dom = new DOMDocument;
    $dom->loadHTML($html);
    $cells = $dom->getElementsByTagName('table');
    $cells = $dom->getElementsByTagName('td');
    foreach ($cells as $cell) {
        echo $cell->nodeValue, PHP_EOL."<br>";
    }
    //echo $html;*/
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "http://www.geonames.org/search.html?q=".$line[0],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);



    $dom = new DOMDocument();
    @$dom->loadHTML($response);

    $xPath = new DOMXPath($dom);
    $elements = $xPath->query("//a/@href");
    //print_r($elements);
    $i=0;
    foreach ($elements as $e) {
        $i++;
        if($i==10 && preg_match('/countries/',$e->nodeValue)){
            $e->nodeValue=substr($e->nodeValue, 11);
            $e->nodeValue=substr($e->nodeValue, 0 ,2);
            echo $e->nodeValue. "<br />";
            fwrite($fp, $line[0].",".$e->nodeValue."\n");
        }
        else if($i==10){
            fwrite($fp, $line[0].",NOT_Available \n");
        }

    }
}
fclose($file);
fclose($fp);
//$query=$_GET['q'];
//$url = 'http://www.geonames.org/search.html?q='.$query;
//$output = file_get_contents($url);
//echo $output;
?>