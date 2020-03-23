<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'country' => ['required', 'integer'],
            'country_name' => ['required', 'string'],
            'region' => ['required', 'integer'],
            'region_name' => ['required', 'string'],
            'city' => ['required', 'integer'],
            'city_name' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'region' => $data['region'],
            'region_name' => $data['region_name'],
            'country' => $data['country'],
            'country_name' => $data['country_name'],
            'city' => $data['city'],
            'city_name' => $data['city_name']
        ]);
    }
}
