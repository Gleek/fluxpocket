<?php
/**
 * @file
 * Contains PocketClient.
 */
namespace Drupal\fluxpocket;

use Guzzle\Common\Collection;
use Guzzle\Plugin\Oauth\OauthPlugin;
use Guzzle\Service\Client;
use Duellsy\Pockpack\PockpackAuth;

/**
 * Service client for the Pocket API.
 */
class PocketClient extends Client {

  /**
   * {@inheritdoc}
   */
  public static function factory($config = array()) {
    $client = new PockpackAuth();
    $consumer_key = $config['client_id'];
    $access_token = $config['access_token'];
    $_SESSION['fluxpocket-api']= array();
    $_SESSION['fluxpocket-api']['consumer_key'] = $consumer_key;
    /*if(!isset($_SESSION['fluxpocket-api']))
      $_SESSION['fluxpocket-api']= array();
    if(!isset($_SESSION['fluxpocket-api']['consumer_key']))
      $_SESSION['fluxpocket-api']['consumer_key'] = $consumer_key;
    if(!isset($_SESSION['fluxpocket-api']['request_token'])){
      $request_token = $client->connect($consumer_key);
      $_SESSION['fluxpocket-api']['request_token'] = $request_token;
    }
    if(!isset($_SESSION['fluxpocket-api']['access_token'])){
      $redirect = null;
      $request_token = $_SESSION['fluxpocket-api']['request_token'];
      drupal_goto($path = "https://getpocket.com/auth/authorize?request_token={$request_token}&redirect_uri={$redirect}");
      $access_token = $client->receiveToken($consumer_key, $request_token);*/
      $_SESSION['fluxpocket-api']['access_token'] = $access_token;
      // }
    return $client;
  }
}
