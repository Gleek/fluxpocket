<?php

/**
 * @file
 * Contains PocketArchiveTask.
 */

namespace Drupal\fluxpocket\Tasks;

/**
 * Event dispatcher for the Pocket Archive URL.
 */
class PocketUpdatedTask extends PocketEntryTaskBase {

  /**
   * {@inheritdoc}
   */
  protected function getRequestArguments() {
    $arguments = array(
      'state'         => 'all',
      'detailType'    => 'complete',
      'sort'          => 'oldest'
    );
    // We store the remote identifier of the last Pocket Entry that was
    // processed so that we can benefit from the 'since_id' query argument.
    $store = fluxservice_key_value('fluxpocket.entries.since');
    if ($since_id = $store->get($this->task['identifier'])) {
      $arguments['since'] = $since_id;
    }
    // If it hasn't been set yet, it means that we are running this for thes
    // first time. In order to prevent flooding and processing of old Entries we
    // limit the request to only three Entries.
    elseif ($since_id === NULL) {
      $arguments['count'] = 3;
    }
    return $arguments;
  }

  /**
   * {@inheritdoc}
   */
  protected function getTime($entries){
    return intval($entries['time_updated'])+1;
  }
}
