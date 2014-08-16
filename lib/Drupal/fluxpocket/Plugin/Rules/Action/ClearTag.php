<?php

/**
 * @file
 * Contains ClearTag.
 */

namespace Drupal\fluxpocket\Plugin\Rules\Action;

use Drupal\fluxpocket\Plugin\Service\PocketAccount;
use Drupal\fluxpocket\Plugin\Service\PocketAccountInterface;
use Drupal\fluxpocket\Rules\RulesPluginHandlerBase;
use Duellsy\Pockpack\PockpackQueue;

/**
 * Action for clearing all the tags for an entry in pocket.
 */
class ClearTag extends RetrieveBase {

  /**
   * Defines the action.
   */
  public static function getInfo() {
    return static::getInfoDefaults() + array(
      'name' => 'fluxpocket_clear_tag',
      'label' => t('Clear all tags from a  Url'),
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

    // Structuring the array of url to be added.
    $item_id = RetrieveBase::getItemIdFromUrl($client, $page_url);

    $pockpack_q = new PockpackQueue();

    $pockpack_q->tags_clear($item_id);

    $client->send($pockpack_q);

  }
}
