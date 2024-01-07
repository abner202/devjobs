<?php

namespace App\Livewire;

use App\Models\Salario;
use App\Models\Vacante;
use Livewire\Component;
use App\Models\Categoria;
use Illuminate\Support\Carbon;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class EditVacante extends Component
{    
    public $vacante_id;
    public $titulo;
    public $salario;
    public $categoria;
    public $empresa;
    public $ultimo_dia;
    public $descripcion;
    public $imagen;
    public $imagen_nueva;

    use WithFileUploads;

    protected $rules=[
        "titulo"=>"required|string",
        "salario"=>"required",
        "categoria"=>"required",
        "empresa"=>"required",
        "ultimo_dia"=>"required",
        "descripcion"=>"required",
        "imagen_nueva"=>"nullable|image|max:1024",

    ];

    use WithFileUploads;
   //pasando la informacion antigua a los campos
    public function mount(Vacante $vacante)// la $vacante es la que se esta pasando de edit.blade
    {   
        $this->vacante_id = $vacante->id; 
        $this->titulo = $vacante->titulo;
        $this->salario = $vacante->salario_id;
        $this->categoria = $vacante->categoria_id;
        $this->empresa=$vacante->empresa;
        $this->ultimo_dia= Carbon::parse( $vacante->ultimo_dia)->format("Y-m-d");
        $this->descripcion=$vacante->descripcion;
        $this->imagen = $vacante->imagen;
    }

    public function editarVacante()
    {
           $datos=$this->validate();//recibe los datos del form;


           //si hay una nueva imagen 
            if($this->imagen_nueva){
                $imagen=$this->imagen_nueva->store("public/vacantes");
                $datos["imagen"] = str_replace("public/vacantes/","",$imagen);

            }

           //encontrar la vacante a editar
           $vacante = Vacante::find($this->vacante_id);//vacante datos de la bd


           //Asignar los valores 
           $vacante->titulo = $datos['titulo'];
           $vacante->salario_id= $datos["salario"];
           $vacante->categoria_id= $datos["categoria"];
           $vacante->empresa= $datos["empresa"] ;
           $vacante->ultimo_dia= $datos["ultimo_dia"];
           $vacante->descripcion= $datos["descripcion"];
           $vacante->imagen= $datos["imagen"]?? $vacante->imagen;

           //guardar la vacante 
           $vacante->save();

           //redireccionar
           session()->flash("mensaje","La Vacante se actualizó correctamente");
           return redirect()->route("vacantes.index");  


        
     }



    public function render()
    {  
         //Consultar DB
        $salarios=Salario::all();
        $categorias=Categoria::all();

        return view('livewire.edit-vacante',[
            "salarios"=>$salarios,
            "categorias"=>$categorias
        ]);
            
    }
}