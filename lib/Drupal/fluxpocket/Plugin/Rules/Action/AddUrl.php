<?php

/**
 * @file
 * Contains UploadFile.
 */

namespace Drupal\fluxpocket\Plugin\Rules\Action;

use Drupal\fluxpocket\Plugin\Service\PocketAccount;
use Drupal\fluxpocket\Plugin\Service\PocketAccountInterface;
use Drupal\fluxpocket\Rules\RulesPluginHandlerBase;
use Duellsy\Pockpack\Pockpack;
use Duellsy\Pockpack\PockpackAuth;
use Duellsy\Pockpack\PockpackQueue;

/**
 * Action for posting a status message on a page.
 */
class AddUrl extends RulesPluginHandlerBase implements \RulesActionHandlerInterface {

  /**
   * Defines the action.
   */
  public static function getInfo() {
    return static::getInfoDefaults() + array(
      'name' => 'fluxpocket_add_url',
      'label' => t('Add Url to Pocket'),
      'parameter' => array(
        'page_url' => array(
          'type' => 'uri',
          'label' => t('Url'),
          'description' => t('The complete url. (e.g. http://www.example.com/page.html'),
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
    // Open a stream for reading and writing
    $consumer_key = $_SESSION['fluxpocket-api']['consumer_key'];
    #$request_token = $_SESSION['fluxpocket-api']['request_token'];
    #drupal_goto("http://localhost/umar/testing/caught.php?con_key={$consumer_key}&req_token={$request_token}");
    $access_token = $_SESSION['fluxpocket-api']['access_token'];
    #$access_token = $client->receiveToken($consumer_key, $request_token);
    $link_info = array(
      'url'       => $page_url
    );

    $pockpack = new Pockpack($consumer_key, $access_token);
    $pockpack_q = new PockpackQueue();

    $pockpack_q->add($link_info);
    $pockpack->send($pockpack_q);
  }
}
