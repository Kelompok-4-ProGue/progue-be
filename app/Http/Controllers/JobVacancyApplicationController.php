<?php

namespace App\Http\Controllers;

use App\Models\JobVacancyApplication;
use Illuminate\Http\Request;

class JobVacancyApplicationController extends Controller
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
            $job_vacancy_applications = JobVacancyApplication::where('company_id', $user->id)->with('Company', 'JobFinder')->get();
            
        } else if ($user->role == 'job_finder') {
            $job_vacancy_applications = JobVacancyApplication::where('job_finder_id', $user->id)->with('Company', 'JobFinder')->get();
        }
        return response()->json([
            'succes' => true,
            'message' => 'Success getting all Job Vacancy Applications',
            'data' => $job_vacancy_applications
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
     * @param  \App\Models\JobVacancyApplication  $jobVacancyApplication
     * @return \Illuminate\Http\Response
     */
    public function show(JobVacancyApplication $jobVacancyApplication)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\JobVacancyApplication  $jobVacancyApplication
     * @return \Illuminate\Http\Response
     */
    public function edit(JobVacancyApplication $jobVacancyApplication)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JobVacancyApplication  $jobVacancyApplication
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JobVacancyApplication $jobVacancyApplication)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JobVacancyApplication  $jobVacancyApplication
     * @return \Illuminate\Http\Response
     */
    public function destroy(JobVacancyApplication $jobVacancyApplication)
    {
        //
    }

    public function apply(Request $request)
    {
        $user = Auth::user();
        if ($user->role == 'job_finder') {
            $input = $request->all();
            $input['job_finder_id'] = $user->id;
            
            // handle motivation_letter upload
            $motivation_letter = time().'.'.$request->motivation_letter->extension();
            $motivation_letter_path = Storage::url('job_application/motivation_letter/');
            $request->motivation_letter->move(public_path($motivation_letter_path), $motivation_letter);
            $input['motivation_letter'] = url('/').$motivation_letter_path.$motivation_letter;
            
            // handle cv upload
            $cv = time().'.'.$request->cv->extension();
            $cv_path = Storage::url('job_application/cv/');
            $request->cv->move(public_path($cv_path), $cv);
            $input['cv'] = url('/').$cv_path.$cv;
            
            // handle portfolio upload
            $portfolio = time().'.'.$request->portfolio->extension();
            $portfolio_path = Storage::url('job_application/portfolio/');
            $request->portfolio->move(public_path($portfolio_path), $portfolio);
            $input['portfolio'] = url('/').$portfolio_path.$portfolio;
            $jobVacancy = JobVacancy::create($input);

            if ($jobVacancy) {
                return response()->json([
                    'success' => true,
                    'message' => 'Successfully applying Job Vacancy',
                    'data' => $jobVacancy
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed applying Job Vacancy',
                    'data' => []
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed applying Job Vacancy',
                'data' => []
            ]);
        }
    }

    public function accept($id)
    {
        $user = Auth::user();
        if ($user->role == 'company') {
            $jobVacancyApplication = JobVacancyApplication::find($id);
            if ($jobVacancyApplication) {
                $jobVacancyApplication->status = 'accepted';
                $jobVacancyApplication->save();
                return response()->json([
                    'success' => true,
                    'message' => 'Successfully accepting Job Vacancy Application',
                    'data' => $jobVacancyApplication
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed accepting Job Vacancy Application',
                    'data' => []
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed accepting Job Vacancy Application',
                'data' => []
            ]);
        }
    }

    public function reject($id)
    {
        $user = Auth::user(); //company
        if ($user->role == 'company') {
            $jobVacancyApplication = JobVacancyApplication::find($id);
            if ($jobVacancyApplication) {
                $jobVacancyApplication->status = 'rejected';
                $jobVacancyApplication->save();
                return response()->json([
                    'success' => true,
                    'message' => 'Successfully rejecting Job Vacancy Application',
                    'data' => $jobVacancyApplication
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed accepting Job Vacancy Application',
                    'data' => []
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed accepting Job Vacancy Application',
                'data' => []
            ]);
        }
    }
}
