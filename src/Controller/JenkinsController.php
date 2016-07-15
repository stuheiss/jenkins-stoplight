<?php namespace App\Controller;

final class JenkinsController extends AbstractController
{
    public function jenkins($request, $response, $params)
    {
        $jenkins = $this->jenkins;
        $stoplights = $this->stoplights;
        $jenkins_servers = $this->jenkins_servers;
        $results = $jenkins->getResults($jenkins_servers, $stoplights);

        $name = isset($params['name'])? $params['name']: 'jenkins user';
        return $this->view->render($response->withHeader('Refresh', '10'), 'jenkins.twig', [
            'name' => $name,
            'results' => $results,
            'timestamp' => date('d/m/y H:m:s'),
        ]);
    }

    public function hello($request, $response, $params)
    {
        echo "#JenkinsController:hello ".var_export($params, true).'<br>';
        $name = isset($params['name'])? $params['name']: 'jenkins user';
        return $this->view->render($response, 'jenkins.twig', [
            'name' => $name
        ]);
    }
}