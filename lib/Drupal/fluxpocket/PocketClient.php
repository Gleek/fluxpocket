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
    if(!isset($_SESSION['fluxpocket-api']['consumer_key']))
      $_SESSION['fluxpocket-api']['consumer_key'] = $consumer_key;
    if(!isset($_SESSION['fluxpocket-api']['request_token']))
      $request_token = $client->connect($consumer_key);
    return $client;
  }
}
