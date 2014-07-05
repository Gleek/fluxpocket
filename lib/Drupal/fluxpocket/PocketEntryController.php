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
    $output = array();
    $client = $account->client();
    $response = $client->retrieve(array(
                  'state' => 'all',
                  'detailType' => 'simple'
                ));
    foreach ($ids as $id) {
      $url = $response->{'list'}->$id->{'given_url'};
      $output[$id] = $url;

    }
    return $output;
  }


  /**
   * {@inheritdoc}
   */
  protected function sendToService(RemoteEntityInterface $entity) {
    throw new \Exception("The entity type {$this->entityType} does not support writing.");
  }

}
