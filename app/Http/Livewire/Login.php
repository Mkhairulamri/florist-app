<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Login extends Component
{
    public $username, $password, $email, $name;
    public $registerForm = true;

    public function render()
    {
        return view('livewire.login');

    }

    public function login(){
        $this->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);

        if(Auth::attempt(array(['email' => $this->email, 'password' => $this->password]))){
            session()->flash('success','Berhasil Login');
        }else{
            session()->flash('error','Email atau Username Salah');
        }
    }


    public function register()
    {
        $this->registerForm = !$this->registerForm;
    }

    public function registerStore()
    {
        $validatedDate = $this->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $this->password = Hash::make($this->password);

        User::create(['name' => $this->name, 'email' => $this->email,'password' => $this->password]);

        session()->flash('message', 'Your register successfully Go to the login page.');

        $this->resetInputFields();

    }
}
