<?php

enum EngineTypeEnum: string
{
    case ELECTRIC = 'electric';
    case GAS = 'gas';
    case HYBRID = 'hybrid';
    
    public static function values(): array
    {
        return array_column(self::cases(), 'value'); // returns ['electric', 'gas', 'hybrid']
    }
}
