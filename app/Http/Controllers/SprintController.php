<?php

namespace App\Http\Controllers;

use App\Sprint;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class SprintController extends Controller
{

    use SoftDeletes;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $lastSprintId = 0;
        if(DB::table('sprint')->count() > 0)
        {
            $lastSprintId = DB::table('sprint')
                              ->orderBy('id', 'desc')
                              ->WhereNull('deleted_at')
                              ->first()->id;
        }


        $sprintList = Sprint::paginate(15);

        return view('sprint.list', compact('sprintList', 'lastSprintId'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sprint.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\SprintRequest $request)
    {
        Sprint::create($request->all());
        return redirect('sprint');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sprint = Sprint::findOrFail($id);
        return view('sprint.view', compact('sprint'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sprint = Sprint::findOrFail($id);
        $sprint->delete();
        return redirect('sprint');
    }
}
