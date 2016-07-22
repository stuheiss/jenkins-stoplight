<?php
$container = $app->getContainer();

// database
$container['db'] = function ($c) {
    $settings = $c->get('settings')['eloquent'];
    return new \App\Util\EloquentService($settings);
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['monolog'];
    $logger = new \Monolog\Logger($settings['name']);
    $logger->pushProcessor(new \Monolog\Processor\UidProcessor());
    $logger->pushHandler(new \Monolog\Handler\StreamHandler($settings['path'], \Monolog\Logger::DEBUG));
    return $logger;
};

// swift mailer
$container['mailer'] = function ($c) {
    $settings = $c->get('settings')['swiftmailer'];
    $mailer = new \App\Util\SwiftMailerService(
        $c->get('settings')['mode'],
        $settings['transport'],
        $settings['options']
    );
    return $mailer;
};

// debbuger
$container['debugger'] = function ($c) {
    return new \App\Util\DebuggerService(
        $c->get('settings')['mode'],
        $c->get('db')->getConnection(),
        $c->get('mailer')->getMailer(),
        $c->get('logger')
    );
};
$container->get('debugger');

// view renderer
$container['view'] = function ($c) {
    $settings = $c->get('settings')['twig'];
    $view = new \Slim\Views\Twig($settings['path'], $settings['options']);
    $view->addExtension(new \App\Util\TwigExtension(
        $c['router'],
        $c['request']->getUri(),
        $c['debugger']
    ));
    return $view;
};

$container['App\ExampleController'] = function ($c) {
    return new \App\Controller\ExampleController($c);
};

$container['App\JenkinsController'] = function ($c) {
    return new \App\Controller\JenkinsController($c);
};

// csfr protection
$container['csrf'] = function () {
    return new \Slim\Csrf\Guard();
};

// flash messages
$container['flash'] = function () {
    return new \Slim\Flash\Messages();
};

// jenkins
$container['jenkins'] = function () {
    return new \App\Util\JenkinsService();
};

$container['stoplights'] = array(
    'default' => '/img/animated-traffic-light-image-0034.gif',
    'green'   => '/img/green-traffic-light.png',
    'blue'    => '/img/green-traffic-light.png',
    'red'     => '/img/red-traffic-light.png',
    'yellow'  => '/img/yellow-traffic-light.png',
);

$container['refresh'] = 15;

$container['jenkins_face'] = array(
    'pancho' => '/img/CbLiqlfp.jpg',
    'butler' => '/img/butler.png',
    'fire'   => '/img/fire-jenkins.png',
    'chef'   => '/img/jenkins-chef.jpg',
    'master' => '/img/master-jenkins.svg',
    'ninja'  => '/img/ninjenkins.svg',
    'super'  => '/img/superhero.svg',
    'cool'   => '/img/view-filters.png',
);

$container['jenkins_servers'] = function () {
    $jenkins_servers = array();
    foreach (explode(',', getenv('JENKINS_SERVERS')) as $url) {
        if (preg_match('/^https?:\/\/([^\/:]+)/', $url, $matches)) {
            $jenkins_servers[$matches[1]] = new \JenkinsKhan\Jenkins($url);
        }
    }
    return $jenkins_servers;
};
