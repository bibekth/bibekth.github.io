<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\User;
use App\Models\Vendor;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Hash;
use Monolog\Handler\IFTTTHandler;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    public function loginCustomer(Request $request)
    {
        $credentials = Validator::make(
            $request->all(),
            [
                'phone_number' => 'required|digits:10',
            ]
        );

        if ($credentials->fails()) {
            return response()->json(['status' => 'Error', 'message' => $credentials->errors()], 422);
        } else {
            // $otp_code =random_int(100000, 999999);
            $otp_code = '123456';
            $time = now();

            $customer = Customer::where('phone_number', $request->phone_number)->first();

            if (!$customer) {
                $message = 'No vendor is registered with this contact number. ' . 'Note: Please contact the administrators.';
                return response()->json(['title' => 'Error', 'message' => $message], 401);
            } else {
                $user = User::where('phone_number', $request->phone_number)->first();

                if (!$user) {
                    $newUser = User::create([
                        'phone_number' => $request->phone_number,
                        'otp_code' => '123456',
                        'otp_registered' => $time,
                        'customer_id' => $customer->id,
                    ]);

                    return response()->json(['OTP Code' => $newUser->otp_code, 'phone_number' => $newUser->phone_number]);
                } else {
                    $otp_registered_time = Carbon::parse($user->otp_registered);
                    $timedifference = $otp_registered_time->diffInSeconds($time);
                    $userotp_code = $user->otp_code;

                    if ($timedifference < 120) {
                        return response()->json(['OTP Code' => $userotp_code, 'phone_number' => $user->phone_number]);
                    } else {
                        $user->phone_number = $user->phone_number;
                        $user->otp_code = $otp_code;
                        $user->otp_registered = $time;
                        $user->customer_id = $customer->id;
                        $user->save();

                        // $this->sendOTP($otp_code,$user->phone_number);

                        return response()->json(['OTP Code' => $otp_code, 'phone_number' => $user->phone_number]);
                    }
                }
            }
        }
    }

    public function loginVendor(Request $request)
    {
        $credentials = Validator::make(
            $request->all(),
            [
                'phone_number' => 'required|digits:10',
            ]
        );

        $phone_number = $request->phone_number;

        if ($credentials->fails()) {
            return response()->json(['status' => 'Error', 'message' => $credentials->errors()], 422);
        } else {
            // $otp_code =random_int(100000, 999999);
            $otp_code = '123456';
            $time = now();
            $vendor = Vendor::where('contact', $phone_number)->first();

            if (!$vendor) {
                $message = 'No vendor is registered with this contact number. ' . 'Note: Please contact the administrators.';
                return response()->json(['title' => 'Error', 'message' => $message], 401);
            } else {
                $user = User::where('phone_number', $phone_number)->first();

                if (!$user) {
                    $newUser = User::create([
                        'phone_number' => $request->phone_number,
                        'otp_code' => '123456',
                        'otp_registered' => $time,
                        'vendor_id' => $vendor->id,
                        'role' => 'Vendor',
                    ]);

                    return response()->json(['otp_code' => $newUser->otp_code, 'phone_number' => $newUser->phone_number]);
                } else {
                    $otp_registered_time = Carbon::parse($user->otp_registered);
                    $timedifference = $otp_registered_time->diffInSeconds($time);
                    $userotp_code = $user->otp_code;

                    if ($timedifference < 120) {
                        return response()->json(['otp_code' => $userotp_code, 'phone_number' => $user->phone_number]);
                    } else {
                        $user->phone_number = $user->phone_number;
                        $user->otp_code = $otp_code;
                        $user->otp_registered = $time;
                        $user->vendor_id = $vendor->id;
                        $user->role = 'Vendor';
                        $user->save();

                        // $this->sendOTP($otp_code,$user->phone_number);

                        return response()->json(['otp_code' => $otp_code, 'phone_number' => $user->phone_number]);
                    }
                }
            }
        }
    }

    public function signUp(Request $request)
    {
        $credentials = Validator::make(
            $request->all(),
            [
                'phone_number' => 'required|digits:10',
            ]
        );

        $phone_number = $request->phone_number;

        if ($credentials->fails()) {
            return response()->json(['status' => 'Error', 'message' => $credentials->errors()], 422);
        } else {
            // $otp_code =random_int(100000, 999999);
            $otp_code = '123456';
            $time = now();
            $vendor = Vendor::where('contact', $phone_number)->first();

            if (!$vendor) {
                $customer = Customer::where('phone_number', $phone_number)->first();
                if (!$customer) {
                    $message = 'This phone number has not been registered yet. Note: Please contact the administrators.';
                    return response()->json(['title' => 'Error', 'message' => $message], 401);
                } else {
                    $user = User::where('phone_number', $phone_number)->first();

                    if (!$user) {
                        $newUser = User::create([
                            'phone_number' => $request->phone_number,
                            'otp_code' => $otp_code,
                            'otp_registered' => $time,
                            'vendor_id' => $vendor->id,
                            'role' => 'Vendor',
                        ]);

                        return response()->json(['otp_code' => $newUser->otp_code, 'phone_number' => $newUser->phone_number]);
                    } else {
                        $otp_registered_time = Carbon::parse($user->otp_registered);
                        $timedifference = $otp_registered_time->diffInSeconds($time);
                        $userotp_code = $user->otp_code;

                        if ($timedifference < 120) {
                            return response()->json(['otp_code' => $userotp_code, 'phone_number' => $user->phone_number]);
                        } else {
                            $user->phone_number = $user->phone_number;
                            $user->otp_code = $otp_code;
                            $user->otp_registered = $time;
                            $user->vendor_id = $vendor->id;
                            $user->role = 'Vendor';
                            $user->save();

                            // $this->sendOTP($otp_code,$user->phone_number);

                            return response()->json(['otp_code' => $otp_code, 'phone_number' => $user->phone_number]);
                        }
                    }
                }
            } else {
                $user = User::where('phone_number', $phone_number)->first();

                if (!$user) {
                    $newUser = User::create([
                        'phone_number' => $request->phone_number,
                        'otp_code' => $otp_code,
                        'otp_registered' => $time,
                        'vendor_id' => $vendor->id,
                        'role' => 'Vendor',
                    ]);

                    return response()->json(['otp_code' => $newUser->otp_code, 'phone_number' => $newUser->phone_number]);
                } else {
                    $otp_registered_time = Carbon::parse($user->otp_registered);
                    $timedifference = $otp_registered_time->diffInSeconds($time);
                    $userotp_code = $user->otp_code;

                    if ($timedifference < 120) {
                        return response()->json(['otp_code' => $userotp_code, 'phone_number' => $user->phone_number]);
                    } else {
                        $user->phone_number = $user->phone_number;
                        $user->otp_code = $otp_code;
                        $user->otp_registered = $time;
                        $user->vendor_id = $vendor->id;
                        $user->role = 'Vendor';
                        $user->save();

                        // $this->sendOTP($otp_code,$user->phone_number);

                        return response()->json(['otp_code' => $otp_code, 'phone_number' => $user->phone_number]);
                    }
                }
            }
        }
    }

    public function otpValidate(Request $request)
    {
        $credentials = Validator::make(
            $request->all(),
            [
                'phone_number' => 'required|digits:10',
                'otp_code' => 'required|digits:6',
            ]
        );

        if ($credentials->fails()) {
            return response()->json(['status' => 'Error', 'message' => $credentials->errors()], 422);
        } else {
            try {
                $user = User::where('phone_number', $request->phone_number)->first();
                // $token = $user->createToken($request->phone_number)->plainTextToken;
                $token = Helper::GenerateToken();

                $time = now();
                $otp_registered_time = Carbon::parse($user->otp_registered);
                $timedifference = $otp_registered_time->diffInSeconds($time);

                if ($timedifference > 120) {
                    $user->otp_code = null;
                    $user->phone_number = $user->phone_number;
                    $user->token = $token;
                    $user->save();
                    return response()->json(['title' => 'Error', 'message' => 'OTP has been expired.'], 400);
                } else {
                    $user->phone_number = $user->phone_number;
                    $user->token = $token;
                    $user->save();

                    $accesst = DB::table('personal_access_tokens')->where('name', $user->phone_number)->get();
                    if (count($accesst) > 1) {
                        DB::table('personal_access_tokens')->where('id', $accesst[0]->id)->delete();
                    }

                    if ($user->otp_code == $request->otp_code) {
                        return response()->json(['title' => 'Success', 'bearer token' => $token, 'user' => $user], 200);
                    } else {
                        return response()->json(['title' => 'Error', 'message' => 'OTP did not match.'], 401);
                    }
                }
            } catch (Exception $e) {
                return response()->json(['status' => 'Error', 'message' => 'Failed to create token for the user.'], 500);
            }
        }
    }

    public function setPassword(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password',
        ]);

        if ($validate->fails()) {
            return response()->json(['status' => 'Error', 'message' => $validate->errors()], 422);
        }
        try {
            $user = Auth::user();
            $password = Hash::make($request->password);
            DB::table('users')->where('id', $user->id)->update(['password' => $password]);
        } catch (Exception $e) {
            return response()->json(['status' => 'Error', 'message' => 'Internal Error'], 500);
        }
        return response()->json(['status' => 'Success', 'message' => 'Password has been set successfully'], 200);
    }

    public function setMpin(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'mpin' => 'required|digits:4|numeric',
        ]);

        if ($validate->fails()) {
            return response()->json(['status' => 'Error', 'message' => $validate->errors()], 422);
        }
        try {
            $user = Auth::user();
            $mpin = DB::table('users')->where('id', $user->id)->update(['mpin' => $request->mpin]);
        } catch (Exception $e) {
            return response()->json(['status' => 'Error', 'message' => 'Internal Error'], 500);
        }
        $message = 'Welcome ' . $user->phone_number . ' to Mero Grocery.';
        return response()->json(['title' => 'Success', 'message' => $message, 'bearer token' => $user->token, 'mpin' => $request->mpin], 200);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required|digits:10',
            'password' => 'required|min:4',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'Error', 'message' => $validator->errors()], 422);
        }
        if (strlen($request->password) == 4) {
            $user = User::where('phone_number', $request->phone_number)->where('mpin', $request->password)->first();
            if (!$user) {
                return response()->json(['status' => 'Error', 'message' => 'Credentials did not matched.'], 401);
            } else {
                $token = Helper::GenerateToken();
                $user->update(['token' => $token]);
                Auth::login($user);
                $authuser = Auth::user();
                $message = 'Welcome ' . $user->phone_number . ' to Mero Grocery.';
                return response()->json(['status' => 'Success', 'message' => $message, 'token' => $token, 'user' => $authuser], 200);
            }
        } else {
            $check = Auth::attempt($request->all());
            if (!$check) {
                return response()->json(['status' => 'Error', 'message' => 'Credentials did not matched.'], 401);
            } else {
                $user = User::where('id', Auth::user()->id)->first();
                $token = Helper::GenerateToken();
                $user->update(['token' => $token]);
                Auth::login($user);
                $authuser = Auth::user();
                $message = 'Welcome ' . $user->phone_number . ' to Mero Grocery.';
                return response()->json(['status' => 'Success', 'message' => $message, 'token' => $token, 'user' => $authuser], 200);
            }
        }
    }
}
