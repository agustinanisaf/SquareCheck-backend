<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        return $query->limit($limit);
    }

    public function queryOrderBy($query, $orderBy)
    {
        $order = explode(',', $orderBy);

        return $query->orderBy($order[0], $order[1]);
    }
}
