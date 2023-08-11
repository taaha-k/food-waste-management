<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FoodWaste;
use Illuminate\Support\Str;
use Auth;
use DB;
use Illuminate\Support\Facades\File;

class FoodWasteController extends Controller
{
    function __construct()
    {     
        $this->middleware('auth');
        $this->middleware('permission:food-waste-list');
        $this->middleware('permission:food-waste-create', ['only' => ['create','store']]);
        $this->middleware('permission:food-waste-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:food-waste-softdelete', ['only' => ['destroy']]);
        $this->middleware('permission:food-waste-restore', ['only' => ['restore']]);
        $this->middleware('permission:food-waste-delete', ['only' => ['delete']]);
    }
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        return view('admin.food-waste.index');
    }
    public function getFoodWaste(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page
        
        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');
        
        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value
        
        // Total records
        $totalRecords = FoodWaste::select('count(*) as allcount')
        ->Where('food_wastes.name', 'like', '%' .$searchValue . '%')
        ->orderBy('id', 'DESC')
        ->count();
        
        $totalRecordswithFilter = FoodWaste::
        select('count(*) as allcount')

        ->Where('food_wastes.name', 'like', '%' .$searchValue . '%')
        ->orderBy('id', 'DESC')
        ->count();
        // Fetch records
        $records = FoodWaste::orderBy($columnName,$columnSortOrder)

        ->Where('food_wastes.name', 'like', '%' .$searchValue . '%')
        ->select('food_wastes.*')
        ->orderBy('id', 'DESC')
        ->skip($start)
        ->take($rowperpage)
        ->get();
        
        $data_arr = array();
        
        foreach($records as $record){
            $id = $record->id;
            $name = $record->name;
            $slug = $record->slug;
            $deleted_at = $record->deleted_at;
            if($record->deleted_at == Null){
                $deleted_at = '0';
            }
            if($record->deleted_at != Null){
                $deleted_at = '1';
            }
            
            $data_arr[] = array(
                "id" => $id,
                "name" => $name,
                "slug" => $slug,
                "deleted_at" => $deleted_at,
            );
        }
        
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );
        
        echo json_encode($response);
        exit;
    }
    
    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        $data = FoodWaste::orderBy('id', 'DESC')->withTrashed()->get();
        return view('admin.food-waste.create', compact('data'));
    }
    
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);
        $input = $request->all();
        
        
        $food_waste = FoodWaste::create($input);
        return redirect()->route('food-waste.index')->with('message','Record Added successfully');
        
    }
    
    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function show($id)
    {
        //
    }
    
    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {
        $food_waste = FoodWaste::find($id);
        return view('admin.food-waste.edit',compact('food_waste'));
    }
    
    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, $id)
    {
        // dd( $input = $request->all());
        $food_waste = FoodWaste::find($id);
        $input = $request->all();
        
        $this->validate($request, [
            'name' => 'required',
        ]);
        
        
        
        if( $food_waste->update($input)){
            // dd($request->all());
            return redirect()->route('food-waste.index')
            ->with('message','Record updated successfully');
        }else{
            return redirect('food-waste.index')->with('message','There is something wrong Please try again.');
        }
        
    }
    
    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function delete(FoodWaste $food_waste,$id)
    {
        
        $food_waste = FoodWaste::find($id)->delete();
        return redirect()->back()->with('message','Record Deleted Successfully!');
    }
    
    
}
