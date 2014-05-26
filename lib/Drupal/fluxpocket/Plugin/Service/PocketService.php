<?php

/**
 * @file
 * Contains PocketService.
 */

namespace Drupal\fluxpocket\Plugin\Service;

use Drupal\fluxservice\Service\OAuthServiceBase;
use Guzzle\Service\Builder\ServiceBuilder;

/**
 * Service plugin implementation for Pocket.
 */
class PocketService extends OAuthServiceBase implements PocketServiceInterface {

  /**
   * Defines the plugin.
   */
  public static function getInfo() {
    return array(
      'name' => 'fluxpocket',
      'label' => t('Pocket'),
      'description' => t('Provides Pocket integration for fluxkraft.'),
      'class' => '\Drupal\fluxpocket\Plugin\Service\PocketServiceHandler',
      'icon font class' => 'icon-book',
      'icon background color' => '#ef3e56',
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getDefaultSettings() {
    return array(
      'service_url' => 'https://getpocket.com',
    ) + parent::getDefaultSettings();
  }

}
