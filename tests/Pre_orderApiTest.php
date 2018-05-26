<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class Pre_orderApiTest extends TestCase
{
    use MakePre_orderTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreatePre_order()
    {
        $preOrder = $this->fakePre_orderData();
        $this->json('POST', '/api/v1/preOrders', $preOrder);

        $this->assertApiResponse($preOrder);
    }

    /**
     * @test
     */
    public function testReadPre_order()
    {
        $preOrder = $this->makePre_order();
        $this->json('GET', '/api/v1/preOrders/'.$preOrder->id);

        $this->assertApiResponse($preOrder->toArray());
    }

    /**
     * @test
     */
    public function testUpdatePre_order()
    {
        $preOrder = $this->makePre_order();
        $editedPre_order = $this->fakePre_orderData();

        $this->json('PUT', '/api/v1/preOrders/'.$preOrder->id, $editedPre_order);

        $this->assertApiResponse($editedPre_order);
    }

    /**
     * @test
     */
    public function testDeletePre_order()
    {
        $preOrder = $this->makePre_order();
        $this->json('DELETE', '/api/v1/preOrders/'.$preOrder->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/preOrders/'.$preOrder->id);

        $this->assertResponseStatus(404);
    }
}
