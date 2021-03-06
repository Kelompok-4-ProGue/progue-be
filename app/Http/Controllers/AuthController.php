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
use Storage;

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
        ]);

        $input = $request->all();
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }
        
        $credentials['email'] = $input['email'];
        $credentials['password'] = Hash::make($input['password']);
        $credentials['role'] = 'company';
        $user = User::create($credentials);
        if ($user) {
            // handle file upload
            $company_letter = time().'.'.$request->letter->extension();
            $company_letter_path = Storage::url('company/letter/');
            $request->letter->move(public_path($company_letter_path), $company_letter);
            
            $input['letter'] = $company_letter;
            $input['user_id'] = $user->id;

            // Create Company
            $company = Company::create($input);

            if ($company) {
                return response()->json([
                    'success'=> true,
                    'message' => 'Successfully created Company!',
                    'data' => $company
                ], 200);
            } else {
                return response()->json([
                    'success'=> false,
                    'message' => 'Failed to create Company!'
                ], 500);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed registering User!',
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
        $user = Auth::user();
        $input = $request->all();

        if ($user->role == 'company') {
            $company = $user->Company;

            if ($request->hasFile('letter')) {
                // handle letter upload
                $company_letter = time().'.'.$request->letter->extension();
                $company_letter_path = Storage::url('company/letter/');
                $request->letter->move(public_path($company_letter_path), $company_letter);
                $input['letter'] = $company_letter;
            }

            // handle small logo upload
            if ($request->company_logo_small) {
                $small_logo_path = Storage::url('company/logo/small_logo/');
                $small_logo = time().'.'.$request->company_logo_small->extension();
                $request->company_logo_small->move(public_path($small_logo_path), $small_logo);
                $input['company_logo_small'] = $small_logo;
            }

            // handle big logo upload
            if ($request->company_logo_big) {
                $big_logo_path = Storage::url('company/logo/big_logo/');
                $big_logo = time().'.'.$request->company_logo_big->extension();
                $request->company_logo_big->move(public_path($big_logo_path), $big_logo);
                $input['company_logo_big'] = $big_logo;
            }
            $company->update($input);
            
        } else if ($user->role == 'job_finder') {
            $job_finder = $user->JobFinder;

            // handle profile image upload
            $input['photo'] = $job_finder->photo;
            if ($request->photo) {
                $photo_path = Storage::url('job_finder/profile_image/');
                $photo = time().'.'.$request->photo->extension();
                $request->photo->move(public_path($photo_path), $photo);
                $input['photo'] = $photo;
            }
            $job_finder->update($input);
        }

        $res = $user;

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
