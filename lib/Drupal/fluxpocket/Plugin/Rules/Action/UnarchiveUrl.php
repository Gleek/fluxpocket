<?php

/**
 * @file
 * Contains Modify url.
 */

namespace Drupal\fluxpocket\Plugin\Rules\Action;

use Drupal\fluxpocket\Plugin\Service\PocketAccount;
use Drupal\fluxpocket\Plugin\Service\PocketAccountInterface;
use Drupal\fluxpocket\Rules\RulesPluginHandlerBase;
use Duellsy\Pockpack\PockpackQueue;

/**
 * Action for posting a status message on a page.
 */
class UnarchiveUrl extends RetrieveBase {

  /**
   * Defines the action.
   */
  public static function getInfo() {
    return static::getInfoDefaults() + array(
      'name' => 'fluxpocket_unarchive_url',
      'label' => t('Remove an item from archive in Pocket'),
      'parameter' => array(
        'page_url' => array(
          'type' => 'uri',
          'label' => t('Url'),
          'description' => t('The complete url of item already added to archives. (e.g. http://www.example.com/page.html) or data-selector (eg. node:url in data selector mode)'),
        ),
        'account' => static::getAccountParameterInfo(),
      ),
    );
  }


  /**
   * Executes the action.
   */
  public function execute($page_url, PocketAccountInterface $account) {
    $client = $account->client();
    $pockpack_q = new PockpackQueue();
    $id = RetrieveBase::getItemIdFromUrl($client, $page_url);
    if ($id !== NULL) {
      $pockpack_q->readd($id);
    }
    $client->send($pockpack_q);
  }

}
