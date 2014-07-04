<?php

/**
 * @file
 * Contains PocketEventHandlerBase.
 */

namespace Drupal\fluxpocket\Plugin\Rules\EventHandler;

use Drupal\fluxservice\Rules\DataUI\AccountEntity;
use Drupal\fluxservice\Rules\EventHandler\CronEventHandlerBase;
use Drupal\fluxpocket\Rules\RulesPluginHandlerBase;

/**
 * Cron-based base class for Pocket event handlers.
 */
abstract class PocketEventHandlerBase extends CronEventHandlerBase {

  /**
   * Returns info-defaults for pocket plugin handlers.
   */
  public static function getInfoDefaults() {
    return RulesPluginHandlerBase::getInfoDefaults();
  }

  /**
   * Rules pocket integration access callback.
   */
  public static function integrationAccess($type, $name) {
    return fluxservice_access_by_plugin('fluxpocket');
  }

  /**
   * Returns info for the provided pocket service account variable.
   */
  public static function getServiceVariableInfo() {
    return array(
      'type' => 'fluxservice_account',
      'bundle' => 'fluxpocket',
      'label' => t('Pocket account'),
      'description' => t('The account used for authenticating with the Pocket API.'),
    );
  }

  /**
   * Returns info for the provided tweet variable.
   */
  public static function getEntryVariableInfo() {
    return array(
      'type' => 'fluxpocket_entry',
      'bundle' => 'entry',
      'label' => t('Added URL'),
      'description' => t('The URL that triggered the event.'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getDefaults() {
    return array(
      'account' => '',
    );
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array &$form_state) {
    $settings = $this->getSettings();

    $form['account'] = array(
      '#type' => 'select',
      '#title' => t('Account'),
      '#description' => t('The service account used for authenticating with the Pocket API.'),
      '#options' => AccountEntity::getOptions('fluxpocket', $form_state['rules_config']),
      '#default_value' => $settings['account'],
      '#required' => TRUE,
      '#empty_value' => '',
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function getEventNameSuffix() {
    return drupal_hash_base64(serialize($this->getSettings()));
  }

}
