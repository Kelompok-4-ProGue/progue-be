<?php

namespace App\Http\Controllers;

use App\Models\JobFinder;
use Illuminate\Http\Request;

class JobFinderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'succes' => true,
            'message' => 'Success getting all Job Finders',
            'data' => JobFinder::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $jobFinder = JobFinder::create($request->all());
        if ($company){
            return response()->json([
                'succes' => true,
                'message' => 'Successfully adding Job Finder',
                'data' => JobFinder::create($request->all()),
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Failed adding Job Finder',
                'data' => [],
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\JobFinder  $jobFinder
     * @return \Illuminate\Http\Response
     */
    public function show(JobFinder $jobFinder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\JobFinder  $jobFinder
     * @return \Illuminate\Http\Response
     */
    public function edit(JobFinder $jobFinder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JobFinder  $jobFinder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JobFinder $jobFinder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JobFinder  $jobFinder
     * @return \Illuminate\Http\Response
     */
    public function destroy(JobFinder $jobFinder)
    {
        //
    }
}
