<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use App\Models\Kangaroo as KangarooModel;
use Illuminate\Support\Facades\Crypt;
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

    /**
     * @return View
     */
    public function allList()
    {
        $data['title'] = "All List";
        $data['sidePanelLink'] = "view_all";
        return view('all_list', $data);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
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

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function editRecord(Request $request)
    {
        $validateDate = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'nickname' => 'nullable|string|max:255',
            'weight' => 'required|numeric|max:100|min:0',
            'height' => 'required|numeric|max:100|min:0',
            'gender' => 'required|string|max:20|min:0',
            'color' => 'nullable|string|max:30',
            'friendliness' => 'nullable|string|max:30',
            'birthday' => 'required|date'
        ]);

        $id = Crypt::decryptString($request->get('id'));
        if ($validateDate->fails()) {
            return response()->json(['errors' => $validateDate->errors()], 422);
        }

        try {
            $kangaroo = KangarooModel::findOrFail($id);
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

    /**
     * @param Request $request
     * @return JsonResponse
     */
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
            $filterString = str_replace('eq', '=', $request->get('$filter'));
            $filterString = str_replace(' ge ', ' >= ', $filterString);
            $filterString = str_replace(' le ', ' <= ', $filterString);
            $filterString = str_replace(' lt ', ' < ', $filterString);
            $filterString = str_replace(' gt ', ' > ', $filterString);
            $filterString = str_replace(' ne ', ' <> ', $filterString);
            $filterDivsAnd = explode('and', $filterString);

            foreach ($filterDivsAnd as $andDiv) {
                $transformedString = "";
                if (strpos($andDiv,' or ')) {
                    $filterDivsOr = explode('or', $andDiv);
                    foreach ($filterDivsOr as $orDiv) {
                        $transformedString = $this->fixLikeFiltering($orDiv);
                        $filterString = str_replace($orDiv, $transformedString, $filterString);
                    }
                } else {
                    $transformedString = $this->fixLikeFiltering($andDiv);
                }

                $filterString = str_replace($andDiv, $transformedString, $filterString);

            }

            if (!empty($filterString)) {
                $kangaroos->whereRaw($filterString);
            }

        }

        $kangaroosData = $kangaroos->get();

        foreach ($kangaroosData as $k => $v) {
            $kangaroosData[$k]->hashedId = Crypt::encryptString($v->id);
        }

        $collection['data'] = $kangaroosData;
        $collection['totalCount'] = KangarooModel::count();
        return response()->json($collection);
    }

    /**
     * @param string $substringString
     * @return string
     */
    private function fixLikeFiltering(string $substringString): string
    {
        if ( (
                str_contains($substringString, 'substringof')
                || str_contains($substringString, 'startswith')
                || str_contains($substringString, 'endswith')
            )
            && str_contains($substringString, 'tolower')) {

            preg_match("/'([^']+)'/", $substringString, $matches);
            $searchString = $matches[1];
            preg_match("/tolower\(([^)]+)\)/", $substringString, $matches);
            $column = $matches[1];

            if (str_contains($substringString, 'startswith')) {
                $strToReplace = "startswith(tolower($column),'$searchString')";
                return str_replace($strToReplace, "LOWER($column) LIKE '$searchString%'", $substringString);
            }
            else if (str_contains($substringString, 'endswith')) {
                $strToReplace = "endswith(tolower($column),'$searchString')";
                return str_replace($strToReplace, "LOWER($column) LIKE '%$searchString'", $substringString);
            }
            else {
                $strToReplace = "substringof('$searchString',tolower($column))";
                return str_replace($strToReplace, "LOWER($column) LIKE '%$searchString%'", $substringString);
            }
        }

        return $substringString;
    }

    /**
     * @param int $hashedId
     * @return void
     */
    public  function editForm(string $hashedId)
    {
        $id = Crypt::decryptString($hashedId);
        $kangaroo = KangarooModel::findOrFail($id);
        $kangaroo->hashedId = $hashedId;

        $data['title'] = "Edit Kangaroo";
        $data['action'] = "edit";
        $data['sidePanelLink'] = "";
        $data['data'] = $kangaroo;

        return view('kangaroo', $data);
    }

}
