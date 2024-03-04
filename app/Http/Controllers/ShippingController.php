<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use Illuminate\Http\Request;
use Mockery\Exception;
use function App\Helpers\api_response;
use function App\Helpers\stakeholder_id;

class ShippingController extends Controller
{
    /*
     * View Shipping details(Customer ID - Customer location -used shipping routes) on map
     */
    public function view_shipping_details()
    {
        try {
            $stakeId = stakeholder_id();


            $data = Shipment::where('stakeholder_id', $stakeId)
                ->with(['customer' => function ($query) {
                    $query->select('public_id', 'name', 'location', 'from', 'to'); // select only these columns from customers table
                }, 'route' => function ($query) {
                    $query->select('location', 'from', 'to', 'usage', 'is'); // select only these columns from routes table
                }])
                ->select('id', 'route_id', 'customer_id', 'location', 'name')
                ->get();

            return api_response(
                data: $data,
                message: __('get-data-successfully')
            );

        } catch (Exception $e) {
            return api_response(
                message: __('public-error'),
                code: $e->getCode() ?? 404,
                errors: [$e->getMessage()]
            );
        }
    }
}
