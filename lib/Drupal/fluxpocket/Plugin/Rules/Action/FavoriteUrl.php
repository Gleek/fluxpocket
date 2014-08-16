<?php

/**
 * @file
 * Contains Favorite url.
 */

namespace Drupal\fluxpocket\Plugin\Rules\Action;

use Drupal\fluxpocket\Plugin\Service\PocketAccount;
use Drupal\fluxpocket\Plugin\Service\PocketAccountInterface;
use Drupal\fluxpocket\Rules\RulesPluginHandlerBase;
use Duellsy\Pockpack\PockpackQueue;

/**
 * Action to add URL to favorites.
 */
class FavoriteUrl extends RetrieveBase {

  /**
   * Defines the action.
   */
  public static function getInfo() {
    return static::getInfoDefaults() + array(
      'name' => 'fluxpocket_favorite_url',
      'label' => t('Favorite an item in Pocket'),
      'parameter' => array(
        'page_url' => array(
          'type' => 'uri',
          'label' => t('Url'),
          'description' => t('The complete url. (e.g. http://www.example.com/page.html) or data-selector (eg. node:url in data selector mode)'),
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
      $pockpack_q->favorite($id);
    }
    $client->send($pockpack_q);
  }

}
