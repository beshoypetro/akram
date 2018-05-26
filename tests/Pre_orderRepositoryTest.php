<?php

use App\Models\Pre_order;
use App\Repositories\Pre_orderRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class Pre_orderRepositoryTest extends TestCase
{
    use MakePre_orderTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var Pre_orderRepository
     */
    protected $preOrderRepo;

    public function setUp()
    {
        parent::setUp();
        $this->preOrderRepo = App::make(Pre_orderRepository::class);
    }

    /**
     * @test create
     */
    public function testCreatePre_order()
    {
        $preOrder = $this->fakePre_orderData();
        $createdPre_order = $this->preOrderRepo->create($preOrder);
        $createdPre_order = $createdPre_order->toArray();
        $this->assertArrayHasKey('id', $createdPre_order);
        $this->assertNotNull($createdPre_order['id'], 'Created Pre_order must have id specified');
        $this->assertNotNull(Pre_order::find($createdPre_order['id']), 'Pre_order with given id must be in DB');
        $this->assertModelData($preOrder, $createdPre_order);
    }

    /**
     * @test read
     */
    public function testReadPre_order()
    {
        $preOrder = $this->makePre_order();
        $dbPre_order = $this->preOrderRepo->find($preOrder->id);
        $dbPre_order = $dbPre_order->toArray();
        $this->assertModelData($preOrder->toArray(), $dbPre_order);
    }

    /**
     * @test update
     */
    public function testUpdatePre_order()
    {
        $preOrder = $this->makePre_order();
        $fakePre_order = $this->fakePre_orderData();
        $updatedPre_order = $this->preOrderRepo->update($fakePre_order, $preOrder->id);
        $this->assertModelData($fakePre_order, $updatedPre_order->toArray());
        $dbPre_order = $this->preOrderRepo->find($preOrder->id);
        $this->assertModelData($fakePre_order, $dbPre_order->toArray());
    }

    /**
     * @test delete
     */
    public function testDeletePre_order()
    {
        $preOrder = $this->makePre_order();
        $resp = $this->preOrderRepo->delete($preOrder->id);
        $this->assertTrue($resp);
        $this->assertNull(Pre_order::find($preOrder->id), 'Pre_order should not exist in DB');
    }
}
