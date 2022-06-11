<?php

namespace App\Http\Controllers;

use App\Models\JobTraining;
use Illuminate\Http\Request;

class JobTrainingController extends Controller
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
            'message' => 'Success getting all Job Vacancies',
            'data' => JobTraining::with('Company')->get(),   
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
        $input = $request->all();
        $input['company_id'] = $request->user()->company->id;
        $jobTraining = JobTraining::create($input);
        if ($jobTraining) {
            return response()->json([
                'success' => true,
                'message' => 'Successfully adding Job Vacancy Data',
                'data' => $jobTraining
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed adding Job Vacancy Data',
                'data' => []
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\JobTraining  $jobTraining
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $jobTraining = JobTraining::find($id);
        if ($jobTraining) {
            return response()->json([
                'success' => true,
                'message' => 'Success getting Job Vacancy Detail',
                'data' => $jobTraining
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed getting Job Vacancy Detail'
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\JobTraining  $jobTraining
     * @return \Illuminate\Http\Response
     */
    public function edit(JobTraining $jobTraining)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JobTraining  $jobTraining
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JobTraining $jobTraining)
    {
        $input = $request->all();
        $jobTraining->update($input);
        if ($jobTraining) {
            return response()->json([
                'success' => true,
                'message' => 'Successfully updating Job Vacancy Data',
                'data' => $jobTraining
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed updating Job Vacancy Data',
                'data' => []
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JobTraining  $jobTraining
     * @return \Illuminate\Http\Response
     */
    public function destroy(JobTraining $jobTraining)
    {
        return response()->json([
            'success' => true,
            'message' => 'Successfully deleting Job Vacancy Data',
            'data' => $jobTraining->delete()
        ]);;
    }
}
