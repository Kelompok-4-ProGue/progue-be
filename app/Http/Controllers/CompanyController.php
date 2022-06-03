<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $company = Company::all();
        if ($company) {
            return response()->json([
                'success' => true,
                'message' => 'Success',
                'data' => $company,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed',
                'data' => [],
            ]);
        }
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
        $company = Company::create($request->all());
        if ($company) {
            return response()->json([
                'success' => true,
                'message' => 'Success adding company',
                'data' => Company::create($request->all()),
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed adding company',
                'data' => [],
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        if ($company) {
            return response()->json([
                'success' => true,
                'message' => 'Success getting company detail',
                'data' => $company,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed getting company detail',
                'data' => [],
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        $company = $company->update($request->all());
        if ($company) {
            return response()->json([
                'success' => true,
                'message' => 'Success updating company',
                'data' => $company,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed updating company',
                'data' => [],
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        $company = $company->delete();
        if ($company) {
            return response()->json([
                'success' => true,
                'message' => 'Success deleting company',
                'data' => $company,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed deleting company',
                'data' => [],
            ]);
        }
    }

    public function profile(Request $request)
    {
        $input = $request->all();
        $company = Company::where('id', $input['id'])->first();
    }
}
