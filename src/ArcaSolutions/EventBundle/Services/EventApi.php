<?php
namespace ArcaSolutions\EventBundle\Services;

use GuzzleHttp\Client;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class EventApi
 *
 * This class is an interface between API edirectory and symfony
 *
 * @package ArcaSolutions\EventBundle\Services
 */
class EventApi
{
    const MONTHS_NUMBER = 12;

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param ContainerInterface $containerInterface
     */
    public function __construct(ContainerInterface $containerInterface)
    {
        $this->container = $containerInterface;
    }

    /**
     * Returns an array with next events from today
     *
     * @param int $year
     * @param     $limit
     *
     * @return array
     */
    public function getDaysWithEventsInAnYear($year = null, $limit)
    {
        /* builds the URL */
        $url = $this->container->get('request')->getSchemeAndHttpHost() . '/API/api3.php';

        /* Request */
        $client = new Client();
        $response = $client->get($url, [
            'query'   => [
                'resource'      => 'event',
                'searchBy'      => 'calendar',
                'numeric_month' => true,
                'year'          => $year
            ],
            'timeout' => 30,
            'headers' => [
                /* used in API */
                'Internal-Access-Calendar' => 'true'
            ]
        ]);
        $json = json_decode($response->getBody()->getContents());

        if (is_null($json)) {
            return [];
        }

        /* workaround because edir changes the output if it's succeed */
        if (isset($json->success) and $json->success === false) {
            return [];
        }

        return $this->convertsDateJsonIntoArray($json, $year, $limit);
    }

    /**
     * Gets data from JSON
     *
     * @param json $json
     * @param int  $year
     * @param int  $limit
     *
     * @return array
     */
    private function convertsDateJsonIntoArray($json, $year, $limit)
    {
        $days_count = 0;
        $array_dates = [];
        $date = new \DateTime('now');

        /* pass through JSON to get dates */
        for ($i = 1; $i <= self::MONTHS_NUMBER and $days_count < $limit; $i++) {
            $i = sprintf('%02d', $i);
            if(isset($json->{$i})) {
                foreach ($json->{$i} as $day) {
                    /* creating a datetime object */
                    $day = \DateTime::createFromFormat('Y-m-d', sprintf('%d-%d-%d', $year, $i, $day));

                    /* get just future dates */
                    if ($day < $date) {
                        continue;
                    }

                    /* get out when reach the limit */
                    if ($days_count >= $limit) {
                        break;
                    }

                    $array_dates[] = $day;
                    $days_count++;
                }}
        }

        return $array_dates;
    }
}
