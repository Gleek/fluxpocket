<?php

/**
 * @file
 * Contains UnfavoriteUrl.
 */

namespace Drupal\fluxpocket\Plugin\Rules\Action;

use Drupal\fluxpocket\Plugin\Service\PocketAccount;
use Drupal\fluxpocket\Plugin\Service\PocketAccountInterface;
use Drupal\fluxpocket\Rules\RulesPluginHandlerBase;
use Duellsy\Pockpack\PockpackQueue;

/**
 * Action for Unfavoriting Url.
 */
class UnfavoriteUrl extends RetrieveBase {

  /**
   * Defines the action.
   */
  public static function getInfo() {
    return static::getInfoDefaults() + array(
      'name' => 'fluxpocket_unfavorite_url',
      'label' => t('Un-Favorite an item in Pocket'),
      'parameter' => array(
        'page_url' => array(
          'type' => 'uri',
          'label' => t('Url'),
          'description' => t('The complete url of item already added to favorites. (e.g. http://www.example.com/page.html) or data-selector (eg. node:url in data selector mode)'),
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
      $pockpack_q->unfavorite($id);
    }
    $client->send($pockpack_q);
  }

}
