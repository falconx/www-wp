<?php
/*
Plugin Name: Deploy
*/

/**
 * Trigger CI build
 */
function trigger_build() {
  $url = 'https://api.travis-ci.com/repo/falconx%2Fwww/requests';

  $fields = array(
    'request' => array(
      'branch' => 'master',
    ),
  );

  // request headers
  $headers = array(
    'Content-Type: application/json',
    'Accept: application/json',
    'Travis-API-Version: 3',
    'Authorization: token ' . getenv('AUTH_TOKEN'),
  );

  // open connection
  $ch = curl_init();

  // set the url, number of POST vars, POST data
  curl_setopt($ch, CURLOPT_VERBOSE, 1);
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_POST, count($fields));
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

  // execute post
  curl_exec($ch);

  // close connection
  curl_close($ch);
}

add_action('update_post', 'trigger_build');