<?php
/**
 * Created by PhpStorm.
 * User: sheiss
 * Date: 7/14/16
 * Time: 2:19 PM
 */

namespace App\Util;

/**
 * Jenkins service provider
 *
 * query jenkins servers and return information
 */
class JenkinsService
{
    private $results = array();

    /**
     * getResults returns the combined results from all configured jenkins jobs
     *
     * @param $jenkins_servers
     * @param $stoplights string array
     *
     * @return array
     */
    public function getResults($jenkins_servers, $stoplights)
    {
        $results=array();

        foreach ($jenkins_servers as $server => $jenkins) {
            foreach ($jenkins->getJobs() as $job) {
                $name = $job->getName();
                $builds = $job->getBuilds();
                // display the latest build which will be the first element in the builds array
                $build = $builds[0];
                $host = explode('.', $server)[0];
                $results["$server-$name"] = array(
                    'host'      => $host,
                    'name'      => $name,
                    'number'    => $build->getNumber(),
                    'result'    => $build->getResult(),
                    'timestamp' => date('m/d/y H:i:s', $build->getTimestamp()),
                    'color'     => array_key_exists($job->getColor(), $stoplights) ? $stoplights[$job->getColor()] : $stoplights['default'],
                );
            }
        }
        $this->results = $results;
        return $results;
    }

    /**
     * getSummary returns summary of results from all configured jenkins jobs
     *
     * @return array
     */
    public function getSummary()
    {
        $summary = array();
        if (!is_null($this->results)) {
            foreach ($this->results as $result) {
                if (array_key_exists($result['result'], $summary)) {
                    $summary[$result['result']]++;
                } else {
                    $summary[$result['result']] = 1;
                }
            }
        }
        return $summary;
    }
}
