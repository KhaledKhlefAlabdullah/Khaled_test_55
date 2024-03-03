<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Entity;
use Illuminate\Http\Request;
use PHPUnit\Exception;
use function App\Helpers\api_response;
use function App\Helpers\stakeholder_id;

class ProductionSitesController extends Controller
{
    public function view_my_production_sites_details()
    {
        try {

            $id = stakeholder_id();
            // this id 032e8400-e29b-41d4-a716-446655440000 for production sites
            $data = Entity::where('category_id', '032e8400-e29b-41d4-a716-446655440000')
                ->where('stakeholder_id', $id)
                ->select([
                    'stakeholder_id',
                    'category_id',
                    'location',
                    'public_id',
                    'usage',
                    'quantity',
                    'is_available',
                    'available_quantity'
                ])->get();

            return api_response(
                data: $data,
                message: __('get-data-successfully')
            );
        } catch (Exception $e) {
            return api_response(
                message: __('get-data-error'),
                code: $e->getCode() ?? 404,
                errors: [$e->getMessage()]
            );
        }
    }


    public function view_current_status_of_production_site(string $id)
    {
        try {

            $user_id = stakeholder_id();
            // this id 032e8400-e29b-41d4-a716-446655440000 for production sites
            $data = Entity::where('category_id', '032e8400-e29b-41d4-a716-446655440000')
                ->where('id', '=', $id)
                ->where('stakeholder_id', $user_id)
                ->select([
                    'stakeholder_id',
                    'category_id',
                    'location',
                    'public_id',
                    'usage',
                    'quantity',
                    'is_available',
                    'available_quantity'
                ])->get();

            return api_response(
                data: $data,
                message: __('get-data-successfully')
            );
        } catch (Exception $e) {
            return api_response(
                message: __('get-data-error'),
                code: $e->getCode() ?? 404,
                errors: [$e->getMessage()]
            );
        }
    }

}
