<?php

namespace App\Http\Livewire;

use Livewire\Component;


class Loginform extends Component
{public $show=false;
    public $password;
    public $guard;
    public function render()
    {
        return view('livewire.loginform');
    }
    public function amount($guard){
        $this->guard=$guard;
        dd($this->guard);
       $this->show=false;

    }
  public function showpassword(){
    if($this->show==false)
       $this->show=true;
    else
    $this->show=false;
  }
  public function hiddenpassword(){

  }
}
