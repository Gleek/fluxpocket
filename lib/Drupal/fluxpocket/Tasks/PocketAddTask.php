<?php

/**
 * @file
 * Contains PocketEntryTaskBase.
 */

namespace Drupal\fluxpocket\Tasks;
/**
 * Pocket Task handler for handling new entries.
 */
class PocketAddTask extends PocketTaskBase {

  /**
   * {@inheritdoc}
   */
  public function runTask() {
    // Retrieve the timestamp of the last update that was processed and
    // continue right there.
    $store = fluxservice_key_value('fluxpocket.entries.since');
    $arguments = $this->getRequestArguments();
    $identifier = $this->task['identifier'];
    $account = $this->getAccount();
    $time = $store->get($identifier);

    $entries = $this->getList($account, $arguments, $time);

    // 1 is added inorder to skip the latest entry.
    $updated_time = intval(end($entries)['time_updated']) + 1;

    if ($entries) {
      $entries = fluxservice_entify_multiple($entries, 'fluxpocket_entry', $account);
      foreach ($entries as $entry) {
        rules_invoke_event($this->getEvent(), $account, $entry);
      }

      // Store the timestamp of the last item that was processed.
      $store->set($this->task['identifier'], $updated_time);
    }
    elseif (empty($arguments['since'])) {
      $store->set($identifier, FALSE);
    }
  }

  /**
   * Retrieves the request arguments based on the event configuration.
   *
   * @return array
   *   The request arguments.
   */
  protected function getRequestArguments() {
    $arguments = array(
      'state'         => 'all',
      'detailType'    => 'complete',
      'sort'          => 'oldest',
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
   * Retrieves the List for the particular task.
   */
  protected function getList($account, $arguments, $time = NULL) {
    $response = $account->client()->retrieve($arguments);

    // Converting to array by
    // encoding the object as json and then decoding as array.
    $entries = json_decode(json_encode($response->{'list'}), TRUE);

    // Editing tags for easy parsing.
    $tags = array();

    foreach ($entries as $index => $elements) {
      if (isset($entries[$index]['tags'])) {
        foreach ($entries[$index]['tags'] as $tag => $name) {
          array_push($tags, $tag);
        }
      }
      $entries[$index]['tags'] = $tags;
      $tags = array();
    }

    // Filtering out entries which are created before the updated time.
    if ($time) {
      foreach ($entries as $index => $elements) {
        if ($entries[$index]['time_added'] < $time) {
          unset ($entries[$index]);
        }
      }
    }
    return $entries;

  }

}
