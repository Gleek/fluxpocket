<?php namespace Drupal\fluxpocket\Tasks\Pocket;

use Drupal\fluxpocket\Tasks\Pocket\NoPocketQueueException;

class Pocket extends PocketBase
{
    private $consumer_key;
    private $access_token;

    public function __construct($consumer_key, $access_token)
    {
        $this->consumer_key = $consumer_key;
        $this->access_token = $access_token;
    }

    /**
     * Responsible for sending the request to the pocket API
     *
     * @param  string $consumer_key
     * @param  string $access_token
     * @param  array $actions
     */
    public function send(PocketQueue $queue = null)
    {
        if( is_null($queue) ) {
            throw new NoPocketQueueException();
        }

        $params = array(
            'actions'       => json_encode($queue->getActions()),
            'consumer_key'  => $this->consumer_key,
            'access_token'  => $this->access_token
        );

        $request = $this->getClient()->get('/v3/send');
        $request->getQuery()->merge($params);

        $response = $request->send();

        // remove any items from the queue
        $queue->clear();

        return json_decode($response->getBody());
    }

    /**
     * Get a list of active bookmarks from the API
     *
     * @param  string $consumer_key
     * @param  string $access_token
     */
    public function retrieve($options = array())
    {
        $params = array(
            'consumer_key'  => $this->consumer_key,
            'access_token'  => $this->access_token
        );

        // combine the creds with any options sent
        $params = array_merge($params, $options);

        $request = $this->getClient()->post('/v3/get');
        $request->getParams()->set('redirect.strict', true);
        $request->setHeader('Content-Type', 'application/json; charset=UTF8');
        $request->setHeader('X-Accept', 'application/json');
        $request->setBody(json_encode($params));
        $response = $request->send();

        return json_decode($response->getBody());
    }

}
