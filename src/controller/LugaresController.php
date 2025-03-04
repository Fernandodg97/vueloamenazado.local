<?php

class LugaresController
{

    // ### Configuracion ### /
    const OBJECT = 1;
    const JSON = 2;

    private $connection;

    public function __construct()
    {
        $this->connection = DatabaseController::connect();
    }

    // ### Lugares ### /

    // Devuelve por GET todos los Lugares del pajaro seleccionado por id /

    // Añade por POST Lugares /

    // Actualiza por PATCH los Lugares del pajaro seleccionado por id /

    // Elimina por DELETE los detalles del pajaro seleccionado por id /
}