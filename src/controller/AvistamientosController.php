<?php

class AvistamientosController
{

    // ### Configuracion ### /
    const OBJECT = 1;
    const JSON = 2;

    private $connection;

    public function __construct()
    {
        $this->connection = DatabaseController::connect();
    }

    // ### Avistamientos ### /

    // Devuelve por GET todos los Avistamientos seleccionado por id pajaro /

    // Añade por POST los Avistamientos /

    // Actualiza por PATCH los Avistamientos seleccionado por id pajaro y id lugar/

    // Elimina por DELETE los Avistamientos seleccionado por id pajaro y id lugar/
}