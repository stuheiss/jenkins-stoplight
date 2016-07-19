<?php namespace App\Controller;

final class JenkinsController extends AbstractController
{
    public function jenkins($request, $response, $params)
    {
        $jenkins = $this->jenkins;
        $stoplights = $this->stoplights;
        $jenkins_servers = $this->jenkins_servers;
        $results = $jenkins->getResults($jenkins_servers, $stoplights);
        $summary = $jenkins->getSummary();
        $refresh = isset($params['refresh'])? $params['refresh']: $this->refresh;

        $name = isset($params['name'])? $params['name']: 'jenkins user';
        $response_arg = $refresh ? $response->withHeader('Refresh', (string)$refresh) : $response;
        return $this->view->render($response_arg, 'jenkins.twig', [
            'name' => $name,
            'results' => $results,
            'summary' => $summary,
            'timestamp' => date('d/m/y H:m:s'),
            'refresh' => ($refresh ? (string)$refresh : '')
        ]);
    }
}
