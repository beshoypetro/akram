<?php

namespace App\Repositories;

use App\Models\products;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class productsRepository
 * @package App\Repositories
 * @version May 15, 2018, 2:15 pm UTC
 *
 * @method products findWithoutFail($id, $columns = ['*'])
 * @method products find($id, $columns = ['*'])
 * @method products first($columns = ['*'])
*/
class productsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'price',
        'discription',
        'number'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return products::class;
    }
}
