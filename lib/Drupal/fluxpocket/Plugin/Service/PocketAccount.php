<?php

/**
 * @file
 * Contains PocketAccount.
 */


namespace Drupal\fluxpocket\Plugin\Service;

use Drupal\fluxpocket\Tasks\Exception;
use Drupal\fluxpocket\PocketClient;
use Drupal\fluxdropbox\DropboxAccountStorage;
use Drupal\fluxservice\Plugin\Entity\Account;
use Drupal\fluxpocket\Tasks\Pocket;
use Drupal\fluxpocket\Tasks\PocketAuth;
use Drupal\fluxpocket\Tasks\PocketQueue;
/**
 * Account plugin implementation for Dropbox.
 */
class PocketAccount extends Account implements PocketAccountInterface {

  /**
   * Defines the plugin.
   */
  public static function getInfo() {
    return array(
      'name' => 'fluxpocket',
      'label' => t('Pocket account'),
      'description' => t('Provides Pocket integration for fluxkraft.'),
      'service' => 'fluxpocket',
    );
  }

  /**
   * {@inheritdoc}
   */
  public function prepareAccount() {
    parent::prepareAccount();
    $key = $this->getService()->getConsumerKey();
    $redirect = $this->getRedirectUrl();
    new Curl($key, $secret, $storage, $redirect);
