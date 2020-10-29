<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function __construct(Request $request)
    {
        $this->limit = $request->get('limit');
        $this->orderBy = $request->get('order_by');
    }

    public function queryLimit($query, $limit)
    {
        return $query->simplePaginate($limit)
            ->appends(request()->query());
    }

    public function queryOrderBy($query, $orderBy)
    {
        $order_table = $orderBy[0];
        $orders = explode(',', $orderBy[1]);
        foreach ($orders as $order) {
            $order_field = substr($order, 1);
            if (Schema::hasColumn($order_table, $order_field)) {
                $order_mode = (substr($order, 0, 1) === '+') ? 'asc' : 'desc';
                $query->orderBy($order_field, $order_mode);   
            }
        }

        return $query;
    }
}
