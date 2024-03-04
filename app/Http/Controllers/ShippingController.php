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
    /**
     * This function retrieves the shipping details for the current stakeholder.
     * It uses the `stakeholder_id()` helper function to get the ID of the current stakeholder.
     * The `Shipment` model with its associated `customer` and `route` relationships is queried.
     * The `customer` and `route` relationships are limited to specific columns using the `with` method.
     * The function returns the data in the expected format using the `api_response()` helper function.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function view_shipping_details()
    {
        try {
            $stakeId = stakeholder_id();


            $shipments = Shipment::where('stakeholder_id', $stakeId)
                ->with(['customer' => function ($query) {
                    $query->select('id', 'name', 'public_id', 'location');
                }, 'route' => function ($query) {
                    $query->select('id', 'public_id', 'from', 'to',);
                }])
                ->select('id', 'route_id', 'customer_id', 'location', 'name')
                ->get();


            return api_response(
                data: $shipments,
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


    public function view_status_shipping(string $id)
    {

    }
}
