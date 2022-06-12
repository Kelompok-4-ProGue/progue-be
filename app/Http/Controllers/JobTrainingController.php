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
                'message' => 'Successfully adding Job Training Data',
                'data' => $jobTraining
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed adding Job Training Data',
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
                'message' => 'Success getting Job Training Detail',
                'data' => $jobTraining
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed getting Job Training Detail'
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
                'message' => 'Successfully updating Job Training Data',
                'data' => $jobTraining
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed updating Job Training Data',
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
            'message' => 'Successfully deleting Job Training Data',
            'data' => $jobTraining->delete()
        ]);
    }

    public function apply(Request $request)
    {
        $user = Auth::user();
        if ($user->role == 'job_finder') {
            $input = $request->all();
            $input['job_finder_id'] = $user->id;
            
            // handle motivation_letter upload
            $motivation_letter = time().'.'.$request->motivation_letter->extension();
            $motivation_letter_path = Storage::url('job_training_application/motivation_letter/');
            $request->motivation_letter->move(public_path($motivation_letter_path), $motivation_letter);
            $input['motivation_letter'] = url('/').$motivation_letter_path.$motivation_letter;
            
            // handle cv upload
            $cv = time().'.'.$request->cv->extension();
            $cv_path = Storage::url('job_training_application/cv/');
            $request->cv->move(public_path($cv_path), $cv);
            $input['cv'] = url('/').$cv_path.$cv;
            
            // handle portfolio upload
            $portfolio = time().'.'.$request->portfolio->extension();
            $portfolio_path = Storage::url('job_training_application/portfolio/');
            $request->portfolio->move(public_path($portfolio_path), $portfolio);
            $input['portfolio'] = url('/').$portfolio_path.$portfolio;
            $jobTraining = JobTraining::create($input);

            if ($jobTraining) {
                return response()->json([
                    'success' => true,
                    'message' => 'Successfully applying Job Training',
                    'data' => $jobTraining
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed applying Job Training',
                    'data' => []
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed applying Job Training',
                'data' => []
            ]);
        }
    }
}
