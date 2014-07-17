<?php

/**
 * @file
 * Contains AddTag.
 */

namespace Drupal\fluxpocket\Plugin\Rules\Action;

use Drupal\fluxpocket\Plugin\Service\PocketAccount;
use Drupal\fluxpocket\Plugin\Service\PocketAccountInterface;
use Drupal\fluxpocket\Rules\RulesPluginHandlerBase;
use Duellsy\Pockpack\PockpackQueue;

/**
 * Action for adding tags to a url to Pocket.
 */
class AddTag extends RetrieveBase {

  /**
   * Defines the action.
   */
  public static function getInfo() {
    return static::getInfoDefaults() + array(
      'name' => 'fluxpocket_add_tag',
      'label' => t('Add tags to a Url in Pocket'),
      'parameter' => array(
        'page_url' => array(
          'type' => 'uri',
          'label' => t('Url'),
          'description' => t('The complete url. (e.g. http://www.example.com/page.html) or data-selector (eg. node:url in data selector mode)'),
        ),
        'tags' => array(
          'type' => 'text',
          'label' => t('List of tags to be added'),
          'description' => t('List of tags, to be added, seperated by comma (,)'),
        ),
        'account' => static::getAccountParameterInfo(),
      ),
    );
  }

  /**
   * Executes the action.
   */
  public function execute($page_url, $tags, PocketAccountInterface $account) {
    $client = $account->client();
    //Structuring the array of tags to be added
    //Getting Tag List
    $tag_ar = explode(",",$tags);
    //Trimming spaces from array list
    $tag_ar = array_filter(array_map('trim', $tag_ar));

    $item_id = RetrieveBase::getItemIdFromUrl($client, $page_url);

    $tag_info = array(
      'item_id'   => $item_id,
      'tags'      => $tag_ar
    );

    $pockpack_q = new PockpackQueue();

    $pockpack_q->tags_add($tag_info);

    $client->send($pockpack_q);

  }
}
