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
      'icon font class' => 'icon-chevron-down',
      'icon background color' => '#ed4055',
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
  public function settingsForm(array &$form_state) {
    $form['help'] = array(
      '#type' => 'markup',
      '#markup' => t('In the following, you need to provide authentication details for communicating with Pocket.<br/>For that, you have to create an application in the <a href="http://getpocket.com/developer/apps/">Pocket app management interface</a> and provide its consumer key below'),
      '#prefix' => '<p class="fluxservice-help">',
      '#suffix' => '</p>',
      '#weight' => -1,
    );
    $form['consumer_key'] = array(
      '#type' => 'textfield',
      '#title' => t('Consumer Key'),
      '#description' => t('The consumer key for authenticating through OAuth.'),
      '#default_value' => $this->getConsumerKey(),
      '#required' => TRUE,
    );
    return $form;
  }

}
