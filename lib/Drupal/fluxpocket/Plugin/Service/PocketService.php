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
      'polling_interval' => 900,
    ) + parent::getDefaultSettings();
  }

  /**
   * Structure of form for the Pocket Service.
   *
   * @param array $form_state
   *
   * @return array $form
   * form to be displayed in the services window
   */
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

    $form['rules']['polling_interval'] = array(
      '#type' => 'select',
      '#title' => t('Polling interval'),
      '#default_value' => $this->getPollingInterval(),
      '#options' => array(0 => t('Every cron run')) + drupal_map_assoc(array(300, 900, 1800, 3600, 10800, 21600, 43200, 86400, 604800), 'format_interval'),
      '#description' => t('The time to wait before checking for updates. Note that the effecitive update interval is limited by how often the cron maintenance task runs. Requires a correctly configured <a href="@cron">cron maintenance task</a>.', array('@cron' => url('admin/reports/status'))),
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function getPollingInterval() {
    return $this->data->get('polling_interval');
  }

  /**
   * {@inheritdoc}
   */
  public function setPollingInterval($interval) {
    $this->data->set('polling_interval', $interval);
    return $this;
  }

}
