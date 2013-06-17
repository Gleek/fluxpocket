<?php

/**
 * @file
 * Contains PocketEntryController.
 */

namespace Drupal\fluxpocket;

use Drupal\fluxservice\Plugin\Entity\AccountInterface;
use Drupal\fluxservice\Plugin\Entity\ServiceInterface;
use Drupal\fluxservice\Entity\RemoteEntityControllerByAccount;
use Drupal\fluxservice\Entity\RemoteEntityInterface;

/**
 * Controller for Pocket Urls.
 */
class PocketEntryController extends RemoteEntityControllerByAccount {

  /**
   * {@inheritdoc}
   */
  protected function loadFromService($ids, ServiceInterface $service, AccountInterface $account = NULL) {
    protected function loadFromService($ids, FluxEntityInterface $agent) {
    // @todo Implement.
  }

  /**
   * {@inheritdoc}
   */
  protected function sendToService(RemoteEntityInterface $entity) {
    // @todo Implement.
  }

}
