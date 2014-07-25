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
use Duellsy\Pockpack\Pockpack;

/**
 * Service client for the Pocket API.
 */
class PocketClient extends Client {

  /**
   * Returns the Pockpack object which is used as base for interaction
   *
   * @param array $config array storing client id and access_token
   *
   * @return object $client Object used as base for interaction with Pocket
   */
  public static function factory($config = array()) {
    $consumer_key = $config['client_id'];
    $access_token = $config['access_token'];
    $client = new Pockpack($consumer_key, $access_token);
    return $client;
  }
}
