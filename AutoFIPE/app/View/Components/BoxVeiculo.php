<?php

namespace App\View\Components;

use App\Models\Veiculo;
use Illuminate\View\Component;
use Illuminate\View\View;

class BoxVeiculo extends Component
{
    public function __construct(
        public Veiculo $veiculo
    ) {}

    public function render(): View
    {
        return view('components.boxVeiculo');
    }
}
