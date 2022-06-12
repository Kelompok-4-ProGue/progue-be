<?php

namespace App\Http\Controllers;

use App\Models\JobTrainingApplication;
use Illuminate\Http\Request;
use Auth;

class JobTrainingApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        if ($user->role == 'company') {
            $job_training_applications = JobTrainingApplication::where('company_id', $user->id)->with('Company', 'JobFinder')->get();
            
        } else if ($user->role == 'job_finder') {
            $job_training_applications = JobTrainingApplication::where('job_finder_id', $user->id)->with('Company', 'JobFinder')->get();
        }
        return response()->json([
            'succes' => true,
            'message' => 'Success getting all Job Training Applications',
            'data' => $job_training_applications
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\JobTrainingApplication  $jobTrainingApplication
     * @return \Illuminate\Http\Response
     */
    public function show(JobTrainingApplication $jobTrainingApplication)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\JobTrainingApplication  $jobTrainingApplication
     * @return \Illuminate\Http\Response
     */
    public function edit(JobTrainingApplication $jobTrainingApplication)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JobTrainingApplication  $jobTrainingApplication
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JobTrainingApplication $jobTrainingApplication)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JobTrainingApplication  $jobTrainingApplication
     * @return \Illuminate\Http\Response
     */
    public function destroy(JobTrainingApplication $jobTrainingApplication)
    {
        //
    }

    public function accept($id)
    {
        $user = Auth::user();
        if ($user->role == 'company') {
            $jobTrainingApplication = JobTrainingApplication::find($id);
            if ($jobTrainingApplication) {
                $jobTrainingApplication->status = 'accepted';
                $jobTrainingApplication->save();
                return response()->json([
                    'success' => true,
                    'message' => 'Successfully accepting Job Training Application',
                    'data' => $jobTrainingApplication
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed accepting Job Training Application',
                    'data' => []
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed accepting Job Training Application',
                'data' => []
            ]);
        }
    }

    public function reject($id)
    {
        $user = Auth::user(); //company
        if ($user->role == 'company') {
            $jobTrainingApplication = JobTrainingApplication::find($id);
            if ($jobTrainingApplication) {
                $jobTrainingApplication->status = 'rejected';
                $jobTrainingApplication->save();
                return response()->json([
                    'success' => true,
                    'message' => 'Successfully rejecting Job Training Application',
                    'data' => $jobTrainingApplication
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed accepting Job Training Application',
                    'data' => []
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed accepting Job Training Application',
                'data' => []
            ]);
        }
    }
}
