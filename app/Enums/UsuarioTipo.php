<?php
namespace App\Enums;

enum UsuarioTipo: string
{
    case Admin = 'admin';
    case Operador = 'operador';
    case Cliente = 'cliente';
}
