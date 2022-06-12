<?php

namespace App\Http\Controllers;

use App\Models\JobVacancy;
use Illuminate\Http\Request;
use Auth;

class JobVacancyController extends Controller
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
            'data' => JobVacancy::with('Company')->get(),
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
        $jobVacancy = JobVacancy::create($input);
        if ($jobVacancy) {
            return response()->json([
                'success' => true,
                'message' => 'Successfully adding Job Vacancy Data',
                'data' => $jobVacancy
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
     * @param  \App\Models\JobVacancy  $jobVacancy
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $jobVacancy = JobVacancy::find($id);
        if ($jobVacancy) {
            return response()->json([
                'success' => true,
                'message' => 'Success getting Job Vacancy Detail',
                'data' => $jobVacancy
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
     * @param  \App\Models\JobVacancy  $jobVacancy
     * @return \Illuminate\Http\Response
     */
    public function edit(JobVacancy $jobVacancy)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JobVacancy  $jobVacancy
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JobVacancy $jobVacancy)
    {
        $input = $request->all();
        $jobVacancy->update($input);
        if ($jobVacancy) {
            return response()->json([
                'success' => true,
                'message' => 'Successfully updating Job Vacancy Data',
                'data' => $jobVacancy
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
     * @param  \App\Models\JobVacancy  $jobVacancy
     * @return \Illuminate\Http\Response
     */
    public function destroy(JobVacancy $jobVacancy)
    {
        $jobVacancy->delete();
        return response()->json([
            'success' => true,
            'message' => 'Successfully deleting Job Vacancy Data',
            'data' => $jobVacancy
        ]);
    }

    public function getCompanyJobVacancy(Request $request)
    {
        
        $company = Auth::user()->Company;
        $jobVacancies = JobVacancy::where('company_id', $company->id)->get();
        return response()->json([
            'success' => true,
            'message' => 'Success getting Job Vacancy Data',
            'data' => $jobVacancies
        ]);
    }
}
