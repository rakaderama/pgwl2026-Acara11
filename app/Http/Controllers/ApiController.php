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
            200,
            [],
            JSON_NUMERIC_CHECK
        );
    }

    public function geojson_point($id)
    {
        $point = $this->points->geojson_point($id);

        if (!$point) {
            return response()->json(['error' => 'Point not found'], 404);
        }

        return response()->json($point, 200, [], JSON_PRETTY_PRINT);
    }

    public function geojson_polylines()
    {
        return response()->json(
            $this->polylines->geojson_polylines(),
            200,
            [],
            JSON_NUMERIC_CHECK
        );
    }

    public function geojson_polyline($id)
    {
        $polyline = $this->polylines->geojson_polyline($id);

        if (!$polyline) {
            return response()->json(['error' => 'Polyline not found'], 404);
        }

        return response()->json($polyline, 200, [], JSON_PRETTY_PRINT);
    }

    public function geojson_polygons()
    {
        return response()->json(
            $this->polygons->geojson_polygons(),
            200,
            [],
            JSON_NUMERIC_CHECK
        );
    }

    public function geojson_polygon($id)
    {
        $polygon = $this->polygons->geojson_polygon($id);

        if (!$polygon) {
            return response()->json(['error' => 'Polygon not found'], 404);
        }

        return response()->json($polygon, 200, [], JSON_PRETTY_PRINT);
    }
}
