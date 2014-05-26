<?php
/**
 * @file
 * Contains PocketClient.
 */
namespace Drupal\fluxpocket;

use Guzzle\Common\Collection;
use Guzzle\Plugin\Oauth\OauthPlugin;
use Guzzle\Service\Client;
use Drupal\fluxpocket\Tasks\Pocket;
use Drupal\fluxpocket\Tasks\PocketAuth;

/**
 * Service client for the Pocket API.
 */
class PocketClient extends Client {

  /**
   * {@inheritdoc}
   */
  public static function factory($config = array()) {
    $client = new PocketAuth();
    $client->connect($config['client_id']);
    return $client;
  }
}
