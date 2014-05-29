<?php

/**
 * @file
 * Contains PocketAccount.
 */


namespace Drupal\fluxpocket\Plugin\Service;

use Drupal\fluxpocket\Tasks\Exception;
use Drupal\fluxpocket\PocketClient;
use Drupal\fluxservice\Plugin\Entity\Account;
use Duellsy\Pockpack\Pockpack;
use Duellsy\Pockpack\PockpackAuth;
use Duellsy\Pockpack\PockpackQueue;
/**
 * Account plugin implementation for Pocket.
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
    $store = fluxservice_tempstore("fluxservice.account.{$this->bundle()}");
    $store->setIfNotExists($this->identifier(), $this);
    $plugin = $this->identifier();
    //Using API to request token
    $pock_auth = new PockpackAuth();
    $request_token = $pock_auth->connect($key);
    $_SESSION[$plugin] = $request_token;
    unset($_GET['destination']);
    drupal_goto($path = "https://getpocket.com/auth/authorize?request_token={$request_token}&redirect_uri={$redirect}");
  }


  public static function getAccountForOAuthCallback($key, $plugin) {
    $store = fluxservice_tempstore("fluxservice.account.{$plugin}");
    return $store->getIfOwner($key);
  }

  /**
   * Builds the URL to redirect to after visiting dropbox for authentication.
   *
   *
   * @return string
   *   The URL to redirect to after visiting the Dropbox OAauth endpoint for
   *   requesting access privileges from a user.
   */
  protected function getRedirectUrl() {
    return url("fluxservice/oauth/{$this->bundle()}/{$this->identifier()}", array('absolute' => TRUE));
  }

  /**
   * {@inheritdoc}
   */
  public function client() {
    $service = $this->getService();
    return PocketClient::factory(array(
      'client_id' => $service->getConsumerKey()
    ));
  }

  /**
   * {@inheritdoc}
   */
  public function getDefaultSettings() {
    return array(
      'access_token' => '',
    );
  }

  /**
   * {@inheritdoc}
   */
  public function accessOAuthCallback() {
    // Ensure that all required request and account values are set.
    $plugin = $this->identifier();
    if (!isset($_SESSION[$plugin])) {
      return FALSE;
    }
    return TRUE;
  }

  /**
   * {@inheritdoc}
   */
  public function processOAuthCallback() {
    $key = $this->getService()->getConsumerKey();
    $request_token = $_SESSION[$this->identifier()];
    $client = new PockPackAuth();
    $data = $client->receiveTokenAndUsername($key, $request_token);
    $this->processAuthorizedAccount($data);

    // Remove the temporarily stored account entity from the tempstore.
    $store = fluxservice_tempstore("fluxservice.account.{$this->bundle()}");
    $store->delete($this->identifier());
  }
  /**
   * {@inheritdoc}
   */
  protected function processAuthorizedAccount(array $response) {
    // Build the label and remote id from the response data.
    $this->setRemoteIdentifier($response['access_token'])->setLabel($response['username']);
  }

}
