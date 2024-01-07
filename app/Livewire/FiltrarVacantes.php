<?php

namespace App\Livewire;

use App\Models\Salario;
use Livewire\Component;
use App\Models\Categoria;

class FiltrarVacantes extends Component
{
    public $termino;
    public $categoria;
    public $salario;

    public function leerDatosFormulario()
    {
        $this->dispatch("terminosBusqueda",$this->termino, $this->categoria, $this->salario); //emitiendo a home vacantes
    }


    public function render()
    {
        $salario=Salario::all();
        $categoria=Categoria::all();
        return view('livewire.filtrar-vacantes',[
            'salarios'=>$salario,
            'categorias'=>$categoria
        ]);
    }
}
