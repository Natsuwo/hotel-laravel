<?php

namespace App\Http\Controllers;

use App\Http\Requests\Guest\LoginRequest;
use App\Http\Requests\Guest\StoreRequest;
use App\Http\Requests\Guest\UpdateRequest;
use App\Models\Guests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Validation\Rules\Password;

class GuestsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perpage = request()->query('perpage', 10);
        $guests = Guests::leftJoin(
            'guest_memberships',
            function ($join) {
                $join->on('guests.point', '>=', 'guest_memberships.point_required')
                    ->whereRaw('guest_memberships.point_required = (select max(point_required) from guest_memberships where guests.point >= point_required)');
            }
        )->select(
            'guests.*',
            'guest_memberships.name as membership_name'
        )->paginate($perpage);

        return view('admin.pages.guest.index', compact('guests'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.guest.create');
    }

    public function guestLogin(LoginRequest $request)
    {
        $checkProvider = Guests::where('email', $request->email)->first();
        if ($checkProvider) {
            if ($checkProvider->provider) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email already registered with ' . $checkProvider->provider . '.'
                ]);
            }
        }

        $credentials = $request->only('email', 'password');



        if ($token = Auth::guard('guest')->attempt($credentials)) {
            $request->authenticateGuest();
            $guest = Auth::guard('guest')->user();
            // $token = JWTAuth::fromUser($guest);
            return response()->json([
                'success' => true,
                'data' => $guest,
                'token' => $token
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'Unauthorized'
        ], 401);
    }

    public function socialLogin(Request $request)
    {
        $guest = Guests::updateOrCreate(
            ['email' => $request->email],
            [
                'uid' => Guests::generateUid(),
                'name' => $request->name,
                'email' => $request->email,
                'avatar' => $request->avatar,
                'provider' => $request->provider,
            ]
        );

        $token = JWTAuth::fromUser($guest);
        return response()->json([
            'success' => true,
            'data' => $guest,
            'token' => $token
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {

        $guest = Guests::create([
            'uid' => $request->uid ? $request->uid : Guests::generateUid(),
            'name' => $request->name,
            'avatar' => $request->avatar,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
        ]);

        if (request()->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => 'Guest created successfully.',
            ]);
        }

        return redirect()->route('admin.guest.index')->with($guest ? ['success' => 'Guest created successfully.'] : ['error' => 'Error creating guest.']);
    }

    public function me()
    {
        return response()->json(Auth::guard('guest')->user());
    }

    public function logout()
    {
        Auth::guard('guest')->logout();
        return response()->json(['message' => 'Logged out successfully']);
    }

    public function refresh()
    {
        return $this->respondWithToken(Auth::guard('guest')->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::guard()->factory()->getTTL() * 60
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function confirmPassword(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('guest')->attempt($credentials)) {
            $request->authenticateGuest();
            $guest = Auth::guard('guest')->user();
            return response()->json([
                'success' =>  $guest ? true : false,
                'message' =>  $guest ? 'Guest authenticated successfully.' : 'Guest not found.',
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'Unauthorized'
        ], 401);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $record = Guests::find($id);
        return view('admin.pages.guest.edit', compact('record'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        $guest = Guests::find($id);
        $guest->update(array_filter([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'nationality' => $request->nationality,
            'passport' => $request->passport,
            'gender' => $request->gender,
            'dob' => $request->dob,
        ], function ($value) {
            return !is_null($value);
        }));

        if ($request->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => 'Guest updated successfully.',
            ]);
        }

        return redirect()->route('admin.guest.index')
            ->with($guest ? ['success' => 'Guest updated successfully.'] : ['error' => 'Error updating guest.']);
    }

    public function updateWithPassword(Request $request)
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);


        if ($request->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => 'Guest updated successfully.',
            ]);
        }

        return redirect()->route('admin.guest.index')
            ->with('success', 'Guest updated successfully.');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $guest = Guests::find($id);
        $guest->delete();
        return redirect()->route('admin.guest.index')
            ->with($guest ? ['success' => 'Guest deleted successfully.'] : ['error' => 'Error deleting guest.']);
    }

    public function makeUid()
    {
        $uid = Guests::generateUid();
        return response()->json(['uid' => $uid]);
    }

    public function getGuests(Request $request)
    {
        $guests = Guests::where('name', 'like', '%' . $request->name . '%')
            ->orWhere('email', 'like', '%' . $request->name . '%')
            ->orWhere('phone', 'like', '%' . $request->name . '%')
            ->orWhere('passport', 'like', '%' . $request->name . '%')
            ->orWhere('uid', 'like', '%' . $request->name . '%')
            ->get();
        return response()->json($guests);
    }
}
