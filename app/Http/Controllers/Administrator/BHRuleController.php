<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\BoardingHouseRule;
use App\Models\Rule;
use Illuminate\Http\Request;

class BHRuleController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');

    }

    public function index(){
        return view('administrator.bh-rules');
    }

    public function show($id){
        return Rule::find($id);
    }

    public function getBhRules(Request $req){
        $sort = explode('.', $req->sort_by);

        //return $sort;

        return Rule::where('rule', 'like', $req->rule . '%')
            ->orderBy($sort[0], $sort[1])->paginate($req->perpage);
    }

    public function store(Request $req){

        $req->validate([
            'rule' => ['required']
        ]);

        Rule::create([
            'rule' => strtoupper($req->rule)
        ]);

        return response()->json([
            'status' => 'saved'
        ]);
    }

    public function update(Request $req, $id){

        $data = Rule::find($id);
        $data->rule = strtoupper($req->rule);
        $data->save();

        return response()->json([
            'status' => 'updated'
        ]);

    }



    public function destroy($id){
        Rule::destroy($id);

        return response()->json([
            'status' => 'deleted'
        ]);
    }


}
