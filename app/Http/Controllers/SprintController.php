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
        // 


        $sprintList = DB::table('sprint')
        ->select('sprint.id as id', 'sprint.name as name', 'sprint.maxtime as maxtime',
            DB::raw('(SELECT 
                      SEC_TO_TIME(SUM(TIME_TO_SEC(estimatedtime))) 
                      FROM task 
                      WHERE task.sprint_id = sprint.id 
                      AND task.deleted_at IS NULL) as sumtime')
            /*DB::raw('(SELECT SUM()
                        SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(timeneeded))) 
                      FROM zeiterfassung 
                      WHERE zeiterfassung.task_id = usertask.task_id 
                      AND zeiterfassung.deleted_at IS NULL) as timeneeded')*/
            )
        ->WhereNull('sprint.deleted_at')
        ->paginate(15);

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
        $sprint = Sprint::find($id);
        $sprint->delete();
        return redirect('/sprint');
    }
}
