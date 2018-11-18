<?php
// src/Controller/IndexController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class IndexController extends AbstractController
{
    public function index()
    {
        return $this->render('index/index.html.twig', ['ingredients' => '', 'search' => '']);
    }
    public function search(Request $request)
    {
        $response = $this->forward('App\Controller\Api\V1\FindController::find', [$request]);
        $result = json_decode($response->getContent(), true);

        $ingredients = empty($request->request->get('ingredients')) ? '' : $request->request->get('ingredients');
        $search = empty($request->request->get('search')) ? '' : $request->request->get('search');

        //TODO:: Si pasa esto guardar la info de la request y enviar al equipo de desarrollo
        if (!is_array($result)) {
            $result = [
                'status' => 'Error',
                'msg'    => 'The service isn\t available in this moment, please, try it later'
            ];
        }

        return $this->render('index/index.html.twig', ['data' => $result, 'ingredients' => $ingredients, 'search' => $search]);
    }
}
