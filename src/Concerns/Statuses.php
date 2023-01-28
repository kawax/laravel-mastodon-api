<?php

namespace Revolution\Mastodon\Concerns;

trait Statuses
{
    /**
     * Get a list of statuses by a user.
     *
     * @param  int  $account_id
     * @param  int  $limit
     * @param  int  $since_id
     * @return array
     */
    public function statuses(int $account_id, int $limit = 40, int $since_id = null): array
    {
        $url = "/accounts/${account_id}/statuses";

        $query = [
            'limit'    => $limit,
            'since_id' => $since_id,
        ];

        return $this->get($url, $query);
    }

    /**
     * Create new status.
     *
     * @param  string  $status
     * @param  array  $options
     * @return array
     */
    public function createStatus(string $status, array $options = null): array
    {
        $url = '/statuses';

        if (empty($options)) {
            $options = [];
        }

        $params = array_merge(['status' => $status], $options);

        return $this->post($url, $params);
    }

    /**
     * Retrieve status.
     *
     * @param  int  $status_id
     * @return array
     */
    public function status(int $status_id): array
    {
        $url = "/statuses/${status_id}";

        return $this->get($url);
    }
}
