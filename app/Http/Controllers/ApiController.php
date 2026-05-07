<?php

namespace App\Http\Controllers;

use App\Models\pointsModel;
use App\Models\polylinesModel;
use App\Models\polygonsModel;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function __construct()
    {
        $this->points = new pointsModel();
        $this->polylines = new polylinesModel();
        $this->polygons = new polygonsModel();
    }

    public function geojson_points()
    {
        return response()->json(
            $this->points->geojson_points(),
            200, [], JSON_NUMERIC_CHECK
        );
    }

    public function geojson_point($id)
    {
        return response()->json(
            $this->points->geojson_point($id),
            200, [], JSON_NUMERIC_CHECK
        );
    }

    public function geojson_polylines()
    {
        return response()->json(
            $this->polylines->geojson_polylines(),
            200, [], JSON_NUMERIC_CHECK
        );
    }

    public function geojson_polygons()
    {
        return response()->json(
            $this->polygons->geojson_polygons(),
            200, [], JSON_NUMERIC_CHECK
        );
    }
}
