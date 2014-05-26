<?php
namespace Drupal\fluxpocket\Tasks\Pocket;

use Guzzle\Http\Client;

abstract class PocketBase
{
    const BASE_URL = 'https://getpocket.com';

    private $client;

    /**
     * Give external access to the base URL
     */
    public function getBaseUrl()
    {
        return self::BASE_URL;
    }

    /**
     * Get the client used to query Pocket.
     *
     * @return  Client HTTP Client used to communicate with Pocket
     */
    public function getClient()
    {
        if ( $this->client ) {
            return $this->client;
        }

        $this->client = new Client(self::BASE_URL);

        return $this->client;
    }
}
