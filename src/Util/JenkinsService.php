<?php
/**
 * Created by PhpStorm.
 * User: sheiss
 * Date: 7/14/16
 * Time: 2:19 PM
 */

namespace App\Util;

class JenkinsService
{
    public function getResults($jenkins_servers, $stoplights)
    {
        $results=array();

        foreach ($jenkins_servers as $jenkins) {
            foreach ($jenkins->getJobs() as $job) {
                $name = $job->getName();
                $builds = $job->getBuilds();
                // display the latest build which will be the first element in the builds array
                $build = $builds[0];
                $results[$name] = array(
                    'name' => $name,
                    'number' => $build->getNumber(),
                    'result' => $build->getResult(),
                    'timestamp' => date('m/d/y H:i:s', $build->getTimestamp()),
                    'color' => array_key_exists($job->getColor(), $stoplights) ? $stoplights[$job->getColor()] : $stoplights['default'],
                );
            }
        }
        return $results;
    }
}
