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
        $timeval   = strtotime('Jan 1 2000');
        $name      = 'Jenkins-Job-master';
        $number    = 42;
        $result    = 'SUCCESS';
        $color     = 'blue';
        $timestamp = '01/01/00 00:00:00';

        $stoplights = $this->container['stoplights'];

        // setup mocks
        $service = m::mock('\JenkinsKhan\Jenkins');
        $job     = m::mock('\JenkinsKhan\Jenkins\Job');
        $build   = m::mock('\JenkinsKhan\Jenkins\Build');

        $service->shouldReceive('getJobs')->andReturn(array($job));

        $job->shouldReceive('getName')->andReturn($name);
        $job->shouldReceive('getBuilds')->andReturn(array($build));
        $job->shouldReceive('getColor')->andReturn($color);

        $build->shouldReceive('getNumber')->andReturn($number);
        $build->shouldReceive('getResult')->andReturn($result);
        $build->shouldReceive('getTimestamp')->andReturn($timeval);

        $jenkins_hostname = 'superjenkins';
        $jenkins_servers  = array($jenkins_hostname => $service);

        // test JenkinsService::getResults()
        $results = $this->jenkinsService->getResults($jenkins_servers, $stoplights);
        $this->assertEquals(array("{$jenkins_hostname}-{$name}" => array(
            'host'      => $jenkins_hostname,
            'name'      => $name,
            'number'    => $number,
            'result'    => $result,
            'timestamp' => $timestamp,
            'color'     => $stoplights[$color],
        )), $results);
    }
}
