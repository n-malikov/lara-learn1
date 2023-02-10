<?php

namespace App\Http\Controllers\Ajax;

use App\Entity\Region;
use Illuminate\Http\Request;

class RegionController
{
    public function get(Request $request): array
    {
        $parent = $request->get('parent') ?: null;

        return array_merge(
            Region::where('parent_id', $parent)
                ->orderBy('name')
                ->select('id', 'name')
                ->get()
                ->toArray()
        );
    }


}
