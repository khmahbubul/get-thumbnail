<?php

if(isset($_POST['url']) && !empty($_POST['url']) && filter_var($_POST['url'], FILTER_VALIDATE_URL)) {
	//gets the HTML data
	$source = getData($_POST['url']);

    // DOM document Creation
    $doc = new DOMDocument;
    libxml_use_internal_errors(true);
    $doc->loadHTML($source);
    libxml_clear_errors();

    // DOM XPath Creation
    $xpath = new DOMXPath($doc);

    // Gets title
    $title = $xpath->query('//title')->item(0)->textContent;

    if(empty($title))
		$title = "No title found";

    // Gets all Open Graph images
    $events = $xpath->query('//meta[@property="og:image"]/@content');

    $image = "";
    for($i = 0; $i < ($events->length); $i++) {
	    $event = $events->item($i);
	    $des = $xpath->evaluate('//meta[@property="og:image"]/@content', $event);
	    if ($des->length > 0) {
	        $image = $des->item(0)->value;
	        break;
	    }
	}

	if(empty($image))
		$image = "image-not-found.gif";


	// Gets all Open Graph descriptions
    $events = $xpath->query('//meta[@property="og:description"]/@content');

    $description = "";
    for($i = 0; $i < ($events->length); $i++) {
	    $event = $events->item($i);
	    $des = $xpath->evaluate('//meta[@property="og:description"]/@content', $event);
	    if ($des->length > 0) {
	        $description = $des->item(0)->value;
	        break;
	    }
	}

	if(empty($description))
		$description = "-- No description found --";

	//output
	$data = array('title' => $title, 'image' => $image, 'description' => $description);
	echo json_encode($data);
}


//fetches HTML data from a URL
function getData($url)
{ 	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_HEADER,0);
	curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.1.7) Gecko/20091221 Firefox/3.5.7 GTB6 (.NET CLR 3.0.4506.2152)");
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
	curl_setopt($ch, CURLOPT_URL, $url);	
	$content = curl_exec($ch);
	curl_close($ch);

	return $content;
}
