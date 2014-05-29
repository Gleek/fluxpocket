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
    $client->connect($config['client_id']);
    return $client;
  }
}
