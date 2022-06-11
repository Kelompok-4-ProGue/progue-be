<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Auth;
use Hash;
use Validator;
use App\Models\User;
use App\Models\Company;
use App\Models\JobFinder;
use App\Http\Requests\LoginRequest;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('Laravel Password Grant Client')->accessToken;
        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
    }

    public function registerCompany(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'address' => 'required|string|max:250',
            'letter' => 'required|file|mimes:pdf|max:2048',
            'email' => 'required|email|unique:users|max:250',
            'password' => 'required|confirmed',
        ]
    );

        $input = $request->all();

        $company_letter = time().'.'.$request->letter->extension();
        $request->letter->move(public_path('storage/company/letter'), $company_letter);
        $input['letter'] = $company_letter;

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }
        
        $credentials['email'] = $input['email'];
        $credentials['password'] = Hash::make($input['password']);
        $credentials['role'] = 'company';
        $user = User::create($credentials);
        if ($user) {
            // Create Company
            $input['user_id'] = $user->id;
            $company = Company::create($input);
            //$company->letter = url($fileStoragePath);

            return response()->json([
                'success'=> true,
                'message' => 'Successfully created user!',
                'data' => $company
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed registering Company',
            ]);
        }
    }

    public function registerJobFinder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'birth_date' => 'required|date',
            'email' => 'required|email|unique:users|max:250',
            'password' => 'required|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $input['password_confirmation'] = bcrypt($input['password_confirmation']);
        $input['role'] = 'job_finder';
        $user = User::create($input);

        if ($user) {
            // Create Job Finder
            $input['user_id'] = $user->id;
            $job_finder = JobFinder::create($input);

            return response()->json([
                'success'=> true,
                'message' => 'Successfully created Job Finder!',
                'data' => $job_finder
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed registering Job Finder',
            ]);
        }
    }

    public function logout (Request $request) {
        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }
    

    public function getProfile(Request $request)
    {
        $user = Auth::user();
        $data = $user->role == 'company' ? $user->Company : $user->JobFinder;
        $data['email'] = $user->email;
        $data['role'] = $user->role;
        
        if ($data) {
            return response()->json([
                'success' => true,
                'message' => 'Success getting user profile',
                'data' => $data
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed getting user profile',
            ]);
        }
    }

    public function updateProfile(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $input = $request->all();
        if ($user->role == 'company') {
            // small logo
            $small_logo = time().'.'.$request->company_logo_small->extension();
            $request->photo->move(public_path('storage/company/logo/small_logo'), $small_logo);
            $input['company_logo_small'] = $small_logo;

            // big logo
            $big_logo = time().'.'.$request->company_logo_big->extension();
            $request->photo->move(public_path('storage/company/logo/big_logo'), $big_logo);
            $input['company_logo_big'] = $big_logo;
            $input['photo'] = Storage::url($big_logo);

            $company = Company::find($user->Company->id);
            $company->update($input);
        } else if ($user->role == 'job_finder') {
            $logo_name = time().'.'.$request->photo->extension();
            $request->photo->move(public_path('job_finder/profile_image'), $logo_name);
            $input['photo'] = $logo_name;

            $job_finder = JobFinder::find($user->JobFinder->id);
            $job_finder->update($input);
        }
        $user->role == 'company' ? $user->Company->update($input) : $user->JobFinder->update($input);
        if ($user) {
            return response()->json([
                'success' => true,
                'message' => 'Success updating user profile',
                'data' => $user
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed updating user profile',
            ]);
        }
    }
}
