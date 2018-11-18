<?php

// tests/Controller/Api/V1/FindControllerTest.php
namespace App\Tests\Controller\Api\V1;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Controller\Api\V1\FindController;

class FindControllerTest extends WebTestCase
{
    public function testShowErrorEmptyPost()
    {
        $request = new Request(
            [],
            [],
            [],
            $_COOKIE,
            $_FILES,
            $_SERVER
        );

        $request->setMethod('POST');

        $find = new FindController();
        $response = $find->find($request);
        $result = json_decode($response->getContent(), true);

        if (!isset($result['code'])) {
            $result['code'] = 0;
        }
        if (!isset($result['status'])) {
            $result['status'] = '';
        }
        if (!isset($result['msg'])) {
            $result['msg'] = '';
        }

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $result['code']);
        $this->assertEquals('Error', $result['status']);
        $this->assertNotEmpty($result['msg']);
    }

    public function testShowPageNoNumber()
    {
        $request = new Request(
            [],
            ['ingredients' => 'onions', 'page' => 'test'],
            [],
            $_COOKIE,
            $_FILES,
            $_SERVER
        );

        $request->setMethod('POST');

        $find = new FindController();
        $response = $find->find($request);
        $result = json_decode($response->getContent(), true);

        if (!isset($result['code'])) {
            $result['code'] = 0;
        }
        if (!isset($result['status'])) {
            $result['status'] = '';
        }
        if (!isset($result['msg'])) {
            $result['msg'] = '';
        }

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $result['code']);
        $this->assertEquals('Error', $result['status']);
        $this->assertNotEmpty($result['msg']);
    }

    public function testShowWorking()
    {
        $request = new Request(
            [],
            ['ingredients' => 'onions', 'search' => 'omelet', 'page' => '1'],
            [],
            $_COOKIE,
            $_FILES,
            $_SERVER
        );

        $request->setMethod('POST');

        $find = new FindController();
        $response = $find->find($request);
        $result = json_decode($response->getContent(), true);

        if (!isset($result['code'])) {
            $result['code'] = 0;
        }
        if (!isset($result['status'])) {
            $result['status'] = '';
        }
        if (!isset($result['msg'])) {
            $result['msg'] = '';
        }
        if (!isset($result['msg'])) {
            $result['results'] = '';
        }

        $this->assertEquals(Response::HTTP_OK, $result['code']);
        $this->assertEquals('Success', $result['status']);
        $this->assertEquals('OK', $result['msg']);
        //Podría fallar si se eliminan las recetas pero si es así cambiamos la query del test para tenerlo controlado siempre
        $this->assertNotEmpty($result['results']);
    }
}
