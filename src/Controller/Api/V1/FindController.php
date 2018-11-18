<?php
// src/Controller/Api/V1/FindController.php
namespace App\Controller\Api\V1;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Guzzle\Http\Exception\ClientErrorResponseException;

class FindController
{
    public function find(Request $request)
    {
        if (!$request->isMethod('post')) {
            return $this->sendResults('Error', 'Method no allowed, the valid method for this call is the method POST', [], Response::HTTP_METHOD_NOT_ALLOWED);
        }

        if (empty($request->request->get('ingredients')) && empty($request->request->get('search'))) {
            return $this->sendResults('Error', 'You must at least the param "ingredients" or "search"', [], Response::HTTP_BAD_REQUEST);
        }

        if (!empty($request->request->get('page')) && !is_numeric($request->request->get('page'))) {
            return $this->sendResults('Error', 'The field page must be a number', [], Response::HTTP_BAD_REQUEST);
        }

        if (!empty($request->request->get('ingredients'))) {
            $params['i'] = $request->request->get('ingredients');
        }
        if (!empty($request->request->get('search'))) {
            $params['q'] = $request->request->get('search');
        }
        if (!empty($request->request->get('page'))) {
            $params['p'] = $request->request->get('page');
        }

        $client = new \GuzzleHttp\Client();

        $data = [];
        try {
            $res = $client->request('GET', $_ENV['URL_API_BASE'] . http_build_query($params));
            $data = json_decode($res->getBody(), true);
        } catch (ClientErrorResponseException $exception) {
            //TODO:: Si pasa esto guardar la info de la request y enviar al equipo de desarrollo
            return $this->sendResults('Error', 'The service isn\'t available in this moment, please, try it later', [], Response::HTTP_SERVICE_UNAVAILABLE);
        }

        if ($res->getStatusCode() != 200 || !isset($data['results'])) {
            $code = $res->getStatusCode();
            if ($code == 200) {
                $code = Response::HTTP_SERVICE_UNAVAILABLE;
            }
            return $this->sendResults('Error', 'The service isn\t available in this moment, please, try it later', [], $code);
        }

        return $this->sendResults('Success', 'OK', ['results' => $data['results']]);
    }

    private function sendResults(string $status, string $msg, array $extra_params, int $code = 200)
    {
        $response = [
            'status' => $status,
            'code'   => $code,
            'msg'    => $msg
        ];

        if (!empty($extra_params)) {
            $response = array_merge($response, $extra_params);
        }

        return new JsonResponse(
            $response,
            $code
        );
    }
}
