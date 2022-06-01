<?php

    function ChuckNorrisChallenge() {
        // Initializes a cURL session
        $ch = curl_init();
        // Pass in a pointer to the URL to work with. The Parameter should be a char * to a null-terminated string which must be URL-encoded in the following format: scheme://host:port/path
        curl_setopt($ch, CURLOPT_URL, "http://api.icndb.com/jokes/random");
        // true to return the transfer as a string of the return value of curl_exec() instead of outputting it directly.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // true to reset the HTTP request method to GET. Since GET is the default, this is only necessary if the request method has been changed.
        curl_setopt($ch, CURLOPT_HTTPGET, 1);
        // Grab URL and pass it to the browser
        $ChuckNorrisJson = curl_exec($ch);
        // If error exists, display
        if ($ChuckNorrisJson == FALSE) {
            die("cURL Error: " . curl_error($ch));
        }
        // Decodes a JSON string and return it
        $ChuckNorrisObj = json_decode($ChuckNorrisJson, true);
        return $ChuckNorrisObj['value']['joke'];
    }
    return ChuckNorrisChallenge();

?>
