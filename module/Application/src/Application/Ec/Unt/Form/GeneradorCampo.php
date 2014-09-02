<?php

namespace Application\Ec\Unt\Form;


class GeneradorCampo {
    
    public function generar() {
        return 'CampoAuto'.rand(1,99);
    }
    
}
