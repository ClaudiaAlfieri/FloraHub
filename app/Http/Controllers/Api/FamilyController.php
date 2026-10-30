<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FamilyResource;
use App\Models\Family;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class FamilyController extends Controller
{
    /**
     * The active families of the catalogue, with the number of species of each one.
     */
    public function __invoke(): AnonymousResourceCollection
    {
        return FamilyResource::collection(Family::withCount('species')->orderBy('name')->get());
    }
}
