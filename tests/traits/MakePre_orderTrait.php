<?php

use Faker\Factory as Faker;
use App\Models\Pre_order;
use App\Repositories\Pre_orderRepository;

trait MakePre_orderTrait
{
    /**
     * Create fake instance of Pre_order and save it in database
     *
     * @param array $preOrderFields
     * @return Pre_order
     */
    public function makePre_order($preOrderFields = [])
    {
        /** @var Pre_orderRepository $preOrderRepo */
        $preOrderRepo = App::make(Pre_orderRepository::class);
        $theme = $this->fakePre_orderData($preOrderFields);
        return $preOrderRepo->create($theme);
    }

    /**
     * Get fake instance of Pre_order
     *
     * @param array $preOrderFields
     * @return Pre_order
     */
    public function fakePre_order($preOrderFields = [])
    {
        return new Pre_order($this->fakePre_orderData($preOrderFields));
    }

    /**
     * Get fake data of Pre_order
     *
     * @param array $postFields
     * @return array
     */
    public function fakePre_orderData($preOrderFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'product_id' => $fake->randomDigitNotNull,
            'user_id' => $fake->randomDigitNotNull,
            'order_id' => $fake->randomDigitNotNull,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $preOrderFields);
    }
}
