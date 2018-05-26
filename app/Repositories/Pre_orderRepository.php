<?php

namespace App\Repositories;

use App\Models\PreOrder;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class Pre_orderRepository
 * @package App\Repositories
 * @version May 15, 2018, 2:18 pm UTC
 *
 * @method Pre_order findWithoutFail($id, $columns = ['*'])
 * @method Pre_order find($id, $columns = ['*'])
 * @method Pre_order first($columns = ['*'])
*/
class Pre_orderRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return PreOrder::class;
    }
}
