<?php
namespace App\Enums;

enum UsuarioStatus: string
{
    case Ativo = 'ativo';
    case Inativo = 'inativo';
    case Suspenso = 'suspenso';
}
