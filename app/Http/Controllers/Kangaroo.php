<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

use App\Models\Kangaroo as KangarooModel;
use Illuminate\Support\Facades\Validator;

class Kangaroo extends Controller
{
    /**
     * @return View
     */
    public function add(): View
    {
        $data['title'] = "Add Kangaroo";
        $data['action'] = "add";
        $data['sidePanelLink'] = "add_kangaroo";
        return view('kangaroo', $data);
    }

    public function allList()
    {
        $data['title'] = "All List";
        $data['sidePanelLink'] = "view_all";
        return view('all_list', $data);
    }

    public function addRecord(Request $request)
    {
        $validateDate = Validator::make($request->all(), [
            'name' => 'required|string|unique:kangaroos|max:255',
            'nickname' => 'nullable|string|max:255',
            'weight' => 'required|numeric|max:100|min:0',
            'height' => 'required|numeric|max:100|min:0',
            'gender' => 'required|string|max:20|min:0',
            'color' => 'nullable|string|max:30',
            'friendliness' => 'nullable|string|max:30',
            'birthday' => 'required|date'
        ]);

        if ($validateDate->fails()) {
            return response()->json(['errors' => $validateDate->errors()], 422);
        }

        $kangaroo = new KangarooModel;
        $kangaroo->name = $request->input('name');
        $kangaroo->nickname = $request->input('nickname');
        $kangaroo->weight = $request->input('weight');
        $kangaroo->height = $request->input('height');
        $kangaroo->gender = $request->input('gender');
        $kangaroo->color = $request->input('color');
        $kangaroo->friendliness = $request->input('friendliness');
        $kangaroo->birthday = $request->input('birthday');
        $result = $kangaroo->save();

        return response()->json($result);
    }

    public function editRecord(Request $request)
    {
        $validateDate = Validator::make($request->all(), [
            'id'    => 'required|numeric',
            'name' => 'required|string|max:255',
            'nickname' => 'nullable|string|max:255',
            'weight' => 'required|numeric|max:100|min:0',
            'height' => 'required|numeric|max:100|min:0',
            'gender' => 'required|string|max:20|min:0',
            'color' => 'nullable|string|max:30',
            'friendliness' => 'nullable|string|max:30',
            'birthday' => 'required|date'
        ]);

        if ($validateDate->fails()) {
            return response()->json(['errors' => $validateDate->errors()], 422);
        }

        try {
            $kangaroo = KangarooModel::findOrFail($request->get('id'));
        } catch (ModelNotFoundException $e) {
            return response()->json(['errors' => ['Kangaroo not found!'] ], 404);
        }

        $kangaroo->name = $request->input('name');
        $kangaroo->nickname = $request->input('nickname');
        $kangaroo->weight = $request->input('weight');
        $kangaroo->height = $request->input('height');
        $kangaroo->gender = $request->input('gender');
        $kangaroo->color = $request->input('color');
        $kangaroo->friendliness = $request->input('friendliness');
        $kangaroo->birthday = $request->input('birthday');
        $result = $kangaroo->save();

        return response()->json($result);
    }

    public function getAll(Request $request)
    {
        $kangaroos = KangarooModel::query();
        if ($request->get('$skip')) {
            $kangaroos->skip($request->get('$skip'));
        }
        if ($request->get('$top')) {
            $kangaroos->take($request->get('$top'));
        }
        if ($request->get('$orderby')) {
            $kangaroos->orderByRaw($request->get('$orderby'));
        }
        if ($request->get('$filter')) {
            $filterString = "";
            preg_match("/'([^']+)'/", $request->get('$filter'), $matches);
            $searchString = $matches[1];

            //fix filter search query
            $filterDivs = explode('or', $request->get('$filter'));
            foreach ($filterDivs as $filter) {
                //searching for strings columns
                if (strpos( $filter, 'tolower(')) {
                    preg_match("/tolower\(([^)]+)\)/", $filter, $matches);
                    $column = $matches[1];
                    $filterString .= (!empty($filterString) ? " OR " : ""). " lower($column) LIKE '%$searchString%'";
                }
                //searching for date columns
                if (strpos( $filter, ' ge ') && strpos( $filter, ' lt ')) {
                    preg_match("/\(\(([^\s+]+)/", $filter, $matches);
                    $column = $matches[1];
                    $filterString .= (!empty($filterString) ? " OR " : ""). " $column LIKE '%$searchString%'";
                }
                //searching for numerical columns
                if (strpos( $filter, ' eq ')) {
                    preg_match("/\(([^\s+]+)/", $filter, $matches);
                    $column = $matches[1];
                    $searchString = floatval($searchString);
                    $filterString .= (!empty($filterString) ? " OR " : ""). " $column = $searchString";
                }
            }

            if (!empty($filterString)) {
                $kangaroos->whereRaw($filterString);
            }

        }

        $kangaroosData = $kangaroos->get();

        $collection['data'] = $kangaroosData;
        $collection['totalCount'] = KangarooModel::count();
        return response()->json($collection);
    }

    /**
     * @param int $id
     * @return void
     */
    public  function editForm(int $id)
    {
        $kangaroo = KangarooModel::findOrFail($id);

        $data['title'] = "Edit Kangaroo";
        $data['action'] = "edit";
        $data['sidePanelLink'] = "";
        $data['data'] = $kangaroo;

        return view('kangaroo', $data);
    }

}
