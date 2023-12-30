<?php

namespace App\Http\Controllers;


use App\Http\Resources\PropertyResource;
use App\Models\Property;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SearchController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Foundation\Application|Response|\Illuminate\Support\Collection
     */
    public function properties(Request $request)
    {
        $name = $request->input('name');
        $price = $request->input('price');
        $bedrooms = $request->input('bedrooms');
        $bathrooms = $request->input('bathrooms');
        $storeys = $request->input('storeys');
        $garages = $request->input('garages');

        try {
            $properties = Property::when($name,
                fn($query) => $query->where('name', 'like', "%$name%")
            )
                ->when($price,
                    fn($query) => $query->whereBetween('price', $price)
                )
                ->when($bedrooms,
                    fn($query) => $query->where('bedrooms', $bedrooms)
                )
                ->when($bathrooms,
                    fn($query) => $query->where('bathrooms', $bathrooms)
                )
                ->when($storeys,
                    fn($query) => $query->where('storeys', $storeys)
                )
                ->when($garages,
                    fn($query) => $query->where('garages', $garages)
                )
                ->get();

            return PropertyResource::collection($properties)->collection;
        } catch (\Throwable) {
            return response(
                "Something went wrong",
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
    }
}
