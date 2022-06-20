<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Enums;

enum MassUnitEnum: string
{
    case LBS = 'KG';
    case KG = 'LBS';
}
