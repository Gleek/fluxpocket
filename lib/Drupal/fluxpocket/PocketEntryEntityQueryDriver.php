<?php

/**
 * @file
 * Contains PocketUserContactQueryDriver.
 */

namespace Drupal\fluxpocket;

use Drupal\fluxservice\Query\RangeRemoteEntityQueryDriverBase;

/**
 * EFQ query driver for Pocket entries.
 */
class PocketEntryEntityQueryDriver extends RangeRemoteEntityQueryDriverBase {

  /**
   * Prepare executing the query.
   *
   * This may be used to check dependencies and to prepare request parameters.
   */
  protected function prepareExecute(\EntityFieldQuery $query) {
    parent::prepareExecute($query);
    if (isset($query->range['length'])) {
      $this->requestParameter = array('count' => intval($query->range['length']));
    }
  }

  /**
   * Make a request.
   *
   * @return array
   *  The response received, containing the items in Pocket.
   */
  protected function makeRequest() {
    $response = $this->getAccount()->client()->retrieve($this->requestParameter);
    //Getting the main list
    $response = $response->{'list'};
    //Changing the object received to array
    $response = json_decode(json_encode($response),true);
    return $response;
  }


  /**
   * {@inheritdoc}
   */
  public function getAccountPlugin() {
    return 'fluxpocket';
  }
}
