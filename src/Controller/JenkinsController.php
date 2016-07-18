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
        $response_arg = $this->refresh ? $response->withHeader('Refresh', (string)$this->refresh) : $response;
        return $this->view->render($response_arg, 'jenkins.twig', [
            'name' => $name,
            'results' => $results,
            'timestamp' => date('d/m/y H:m:s'),
            'refresh' => ($this->refresh ? (string)$this->refresh : '')
        ]);
    }

    public function hello($request, $response, $params)
    {
        $name = isset($params['name'])? $params['name']: 'jenkins user';
        return $this->view->render($response, 'master.twig', [
            'name' => $name
        ]);
    }
}
