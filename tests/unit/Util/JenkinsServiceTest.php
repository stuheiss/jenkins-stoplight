<?php
namespace App\Util;

use \Mockery as m;

// codecept_debug('whatever);

class JenkinsServiceTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    private $jenkinsService;
    private $app;
    private $settings;
    private $container;

    protected function _before()
    {
        $app = null;
        // Instantiate the app
        $this->settings = require __DIR__ . '/../../../app/settings.php';
        $this->app = $app = new \Slim\App($this->settings);
        // Set up dependencies
        require __DIR__ . '/../../../app/dependencies.php';
        // // Register middleware
        require __DIR__ . '/../../../app/middleware.php';
        // Register routes
        require __DIR__ . '/../../../app/routes.php';

        $this->container = $app->getContainer();
        $this->jenkinsService = new JenkinsService();
    }

    protected function _after()
    {
        m::close();
    }

    // tests
    public function testGetResults()
    {
        $timeval = strtotime('Jan 1 2000');
        $name = 'Jenkins-Job-master';
        $number = 42;
        $result = 'SUCCESS';
        $color = 'blue';
        $timestamp = '01/01/00 00:00:00';

        $stoplights = $this->container['stoplights'];

        /***
        $jenkins_servers = $this->container['jenkins_servers'];
        $this->assertEquals(array('jenkins', 'jenkins2'), array_keys($jenkins_servers));
        foreach ($jenkins_servers as $j) {
            $this->assertEquals('JenkinsKhan\Jenkins', get_class($j));
        }
        ***/

        // setup mocks
        $service = m::mock('\JenkinsKhan\Jenkins');
        $job = m::mock('\JenkinsKhan\Jenkins\Job');
        $service->shouldReceive('getJobs')->andReturn(array($job));
        $job->shouldReceive('getName')->andReturn($name);
        $build = m::mock('\JenkinsKhan\Jenkins\Build');
        $build->shouldReceive('getNumber')->andReturn($number);
        $build->shouldReceive('getResult')->andReturn($result);
        $build->shouldReceive('getTimestamp')->andReturn($timeval);
        $job->shouldReceive('getBuilds')->andReturn(array($build));
        $job->shouldReceive('getColor')->andReturn($color);
        $jenkins_servers = array($service);

        // test JenkinsService::getResults()
        $results = $this->jenkinsService->getResults($jenkins_servers, $stoplights);
        $this->assertEquals(array($name => array(
            'name' => $name,
            'number' => $number,
            'result' => $result,
            'timestamp' => $timestamp,
            'color' => $stoplights[$color],
        )), $results);
    }
}
