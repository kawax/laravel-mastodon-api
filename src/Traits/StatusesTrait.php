<?php

namespace Revolution\Mastodon\Traits;

trait StatusesTrait
{
    /**
     * @param int $account_id
     * @param int $limit
     * @param int $since_id
     *
     * @return array
     */
    public function status_list(int $account_id, int $limit = 40, int $since_id = null): array
    {
        $url = "/accounts/${account_id}/statuses";

        $query = [
            'limit'    => $limit,
            'since_id' => $since_id,
        ];

        return $this->get($url, $query);
    }

    /**
     * @param string $status
     * @param array  $options
     *
     * @return array
     */
    public function status_post(string $status, array $options = []): array
    {
        $url = '/statuses';

        $params = array_merge(['status' => $status,], $options);

        return $this->post($url, $params);
    }

    /**
     * @param int $status_id
     *
     * @return array
     */
    public function status_get(int $status_id): array
    {
        $url = "/statuses/${status_id}";

        return $this->get($url);
    }
}
