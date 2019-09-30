<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Property;

class PropertyController
{
    public function getAll(Request $request)
    {
        $cur_page = $request->current_page;
        $per_page = 20;

        $offset = ($cur_page - 1) * $per_page;

        $sortCol = "id";
        $sortDir = "asc";

        if ($request->sort) {
            $sortDir = $request->sort;
        }
        if ($request->sortKey) {
            $sortCol = $request->sortKey;
        }

        $query = Property::orderBy($sortCol, $sortDir);

        if ($request->id) {
            $query->where('id', $request->id);
        }
        if ($request->bedroom) {
            $query->where('bedroom', $request->bedroom);
        }
        if ($request->bathroom) {
            $query->where('bathroom', $request->bathroom);
        }
        if ($request->property_type) {
            $query->where('property_type_id', $request->property_type);
        }
        if ($request->status) {
            $query->where('status_id', $request->status);
        }
        if ($request->for_sale != '') {
            $query->where('for_sale', $request->for_sale);
        }
        if ($request->for_rent != '') {
            $query->where('for_rent', $request->for_rent);
        }
        if ($request->title) {
            $query->where('title', 'like', "%$request->title%");
        }
        if ($request->description) {
            $query->where('description', 'like', "%$request->description%");
        }

        if ($request->projectName) {
            $query->whereHas('project', function($q) use ($request){
                $q->where('name', 'like', "%$request->projectName%");
            });
        }

        if($request->country){
            $query->whereHas('region', function($q) use ($request){
                $q->where('country_id', $request->country);
            });
        }

        $total = (clone $query)->count();
        $rows = $query->limit($per_page)->offset($offset)->get();

        $last_page = ceil($total / $per_page);

        if ($cur_page == 1) {
            $prev_page_url = null;

            if ($total > $per_page) {
                $next_page_url = url('posts/all') . '?page=2';
            } else {
                $next_page_url = null;
            }
        } else {
            if ($cur_page > 1 && $cur_page < $last_page) {
                $next_page_url = url('posts/all') . '?page=' . ($cur_page + 1);
                $prev_page_url = url('posts/all') . '?page=' . ($cur_page - 1);
            } else {
                $next_page_url = null;
                $prev_page_url = url('posts/all') . '?page=' . ($cur_page - 1);
            }
        }

        if (count($rows)) {
            return response()->json([
                'links' => [
                    'pagination' =>
                        [
                            'total' => $total,
                            'per_page' => $per_page,
                            'current_page' => $cur_page,
                            'last_page' => $last_page,
                            'next_page_url' => $next_page_url,
                            'prev_page_url' => $prev_page_url,
                            'from' => $rows[0]->id,
                            'to' => $rows[$rows->count() - 1]->id
                        ]
                ],
                'data' => $rows
            ]);
        } else {
            return response()->json([
                'links' => [
                    'pagination' =>
                        [
                            'total' => 0,
                            'per_page' => $per_page,
                            'current_page' => 0,
                            'last_page' => null,
                            'next_page_url' => null,
                            'prev_page_url' => null,
                            'from' => null,
                            'to' => null
                        ]
                ],
                'data' => []
            ]);
        }
    }
}
