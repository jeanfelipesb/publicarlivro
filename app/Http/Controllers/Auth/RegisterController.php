<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Mail;
use App\Mail\Welcome;

class RegisterController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Register Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles the registration of new users as well as their
      | validation and creation. By default this controller uses a trait to
      | provide this functionality without requiring any additional code.
      |
     */

use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/painel';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data) {
        $rules = array(
            'name' => 'required|string|max:255',
            'sobrenome' => 'required|string|max:255',
            'cpf' => 'required|string|max:14',
            'telefone_principal' => 'required|string|max:9',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'cep' => 'required|string|max:9',
            'ddd' => 'required|string|max:2',
            'estado' => 'required|string|max:2',
            'cidade' => 'required|string|max:255',
            'bairro' => 'required|string|max:255',
            'endereco' => 'required|string|max:255',
            'numero' => 'required|string|max:255',
        );
        $validator = Validator::make($data, $rules, $messages = [
                    'name.required' => 'O campo name ?? de preenchimento obrigat??rio!',
                    'sobrenome.required' => 'O campo sobrenome ?? de preenchimento obrigat??rio!',
                    'cpf.required' => 'O campo CPF ?? de preenchimento obrigat??rio!',
                    'telefone.required' => 'O campo telefone ?? de preenchimento obrigat??rio!',
                    'cep.required' => 'O campo CEP ?? de preenchimento obrigat??rio!',
                    'ddd.required' => 'O campo DDD ?? de preenchimento obrigat??rio!',
                    'telefone_principal.required' => 'O campo estado ?? de preenchimento obrigat??rio!',
                    'cidade.required' => 'O campo cidade ?? de preenchimento obrigat??rio!',
                    'bairro.required' => 'O campo bairro ?? de preenchimento obrigat??rio!',
                    'endereco.required' => 'O campo endere??o ?? de preenchimento obrigat??rio!',
                    'numero.required' => 'O campo n??mero ?? de preenchimento obrigat??rio!',
                    'email.email' => 'E-mail inv??lido!',
                    'password.required' => 'O campo senha ?? de preenchimento obrigat??rio!',
                    'password.min' => 'O campo senha ?? necess??rio minido de 6 caracteres ',
                    'password.confirmed' => 'As senhas n??o conferem',
        ]);
        

        return $validator;
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data) {
        $user = [
            'name' => $data['name'],
            'sobrenome' => $data['sobrenome'],
            'cpf' => $data['cpf'],
            'ddd' => $data['ddd'],
            'telefone_principal' => $data['telefone_principal'],
            'telefone' => $data['telefone'],
            'cep' => $data['cep'],
            'estado' => $data['estado'],
            'cidade' => $data['cidade'],
            'bairro' => $data['bairro'],
            'endereco' => $data['endereco'],
            'numero' => $data['numero'],
            'email' => $data['email'],
            'complemento' => $data['complemento'],
            'password' => bcrypt($data['password']),
        ];

        Mail::to($user['email'])->send(new Welcome($user));
        return User::create($user);
    }

}
