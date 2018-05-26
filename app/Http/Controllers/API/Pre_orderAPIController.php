<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePre_orderAPIRequest;
use App\Http\Requests\API\UpdatePre_orderAPIRequest;
use App\Models\Pre_order;
use App\Repositories\Pre_orderRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class Pre_orderController
 * @package App\Http\Controllers\API
 */

class Pre_orderAPIController extends AppBaseController
{
    /** @var  Pre_orderRepository */
    private $preOrderRepository;

    public function __construct(Pre_orderRepository $preOrderRepo)
    {
        $this->preOrderRepository = $preOrderRepo;
    }

    /**
     * Display a listing of the Pre_order.
     * GET|HEAD /preOrders
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->preOrderRepository->pushCriteria(new RequestCriteria($request));
        $this->preOrderRepository->pushCriteria(new LimitOffsetCriteria($request));
        $preOrders = $this->preOrderRepository->all();

        return $this->sendResponse($preOrders->toArray(), 'Pre Orders retrieved successfully');
    }

    /**
     * Store a newly created Pre_order in storage.
     * POST /preOrders
     *
     * @param CreatePre_orderAPIRequest $request
     *
     * @return Response
     */
    public function store(CreatePre_orderAPIRequest $request)
    {
        $input = $request->all();

        $preOrders = $this->preOrderRepository->create($input);

        return $this->sendResponse($preOrders->toArray(), 'Pre Order saved successfully');
    }

    /**
     * Display the specified Pre_order.
     * GET|HEAD /preOrders/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Pre_order $preOrder */
        $preOrder = $this->preOrderRepository->findWithoutFail($id);

        if (empty($preOrder)) {
            return $this->sendError('Pre Order not found');
        }

        return $this->sendResponse($preOrder->toArray(), 'Pre Order retrieved successfully');
    }

    /**
     * Update the specified Pre_order in storage.
     * PUT/PATCH /preOrders/{id}
     *
     * @param  int $id
     * @param UpdatePre_orderAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePre_orderAPIRequest $request)
    {
        $input = $request->all();

        /** @var Pre_order $preOrder */
        $preOrder = $this->preOrderRepository->findWithoutFail($id);

        if (empty($preOrder)) {
            return $this->sendError('Pre Order not found');
        }

        $preOrder = $this->preOrderRepository->update($input, $id);

        return $this->sendResponse($preOrder->toArray(), 'Pre_order updated successfully');
    }

    /**
     * Remove the specified Pre_order from storage.
     * DELETE /preOrders/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Pre_order $preOrder */
        $preOrder = $this->preOrderRepository->findWithoutFail($id);

        if (empty($preOrder)) {
            return $this->sendError('Pre Order not found');
        }

        $preOrder->delete();

        return $this->sendResponse($id, 'Pre Order deleted successfully');
    }
}
