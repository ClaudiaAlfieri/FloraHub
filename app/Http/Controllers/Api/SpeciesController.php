<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SpeciesResource;
use App\Models\Species;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SpeciesController extends Controller
{
    /**
     * The species of the catalogue, 15 per page, filtered by ?search= and ?family=slug.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $search = $request->string('search')->trim()->toString();
        $family = $request->string('family')->trim()->toString();

        $species = Species::query()
            ->with('family')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('scientific_name', 'like', "%{$search}%")
                        ->orWhere('common_name', 'like', "%{$search}%");
                });
            })
            ->when($family !== '', function ($query) use ($family) {
                $query->whereRelation('family', 'slug', $family);
            })
            ->orderBy('scientific_name')
            ->paginate(15)
            ->withQueryString();

        return SpeciesResource::collection($species);
    }

    /**
     * One species of the catalogue, with its family.
     */
    public function show(Species $species): SpeciesResource
    {
        return new SpeciesResource($species->load('family'));
    }
}
