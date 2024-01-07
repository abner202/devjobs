<?php

namespace App\Livewire;

use App\Models\Vacante;
use App\Notifications\NuevoCandidato;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class PostularVacante extends Component
{   
   
    use WithFileUploads;

    public $cv;
    public $vacante;

    //validacion
    protected $rules = [
        "cv" => "required|mimes:pdf"
    ];



    public function mount(Vacante $vacante)
    {
        $this->vacante=$vacante;
    }



    public function postularme()
    {

        $datos=$this->validate();

        //Almacenar cv en disco duro 
        $cv=$this->cv->store("public/cv");
        $datos["cv"]=str_replace("public/cv/","",$cv);

        //crear el candidato a la vacante 
        $this->vacante->candidatos()->create([
            "user_id"=> auth()->user()->id,
            "cv"=> $datos['cv']
            //vacante no se coloca porque se asigna aut por la relacion

        ]);


        // crear notificacion y enviar el email 
        $this->vacante->reclutador->notify(new NuevoCandidato($this->vacante->id, $this->vacante->titulo,auth()->user()->id));

        //mostrar al user un mensaje de ok
        session()->flash("mensaje", "Se envió correctamente tu información, mucha suerte");
        return redirect()->back();
    }

    public function render()
    {   
        
        return view('livewire.postular-vacante');
    }
}
