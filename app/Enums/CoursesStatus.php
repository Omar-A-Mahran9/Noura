<?php
namespace App\Enums;


enum CoursesStatus:int{

    case pending = 1;
    case approved = 2;
    case rejected = 3;

    public static function values(): array
    {
        return array_map(fn($case) => [
            'value' => $case->value,
            'name' => ucfirst($case->name), // Capitalize the first letter for display
        ], self::cases());    }
    
}   