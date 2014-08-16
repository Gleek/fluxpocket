<?php

/**
 * @file
 * Contains PocketAccountInterface.
 */

namespace Drupal\fluxpocket\Plugin\Service;

use Drupal\fluxservice\Service\OAuthAccountInterface;

/**
 * Interface for Pocket accounts.
 */
interface PocketAccountInterface extends OAuthAccountInterface {

  /**
   * Gets the LinkedIn client object.
   *
   * @return \Guzzle\Service\Client
   *   The web service client for the LinkedIn API.
   */
  public function client();

}
