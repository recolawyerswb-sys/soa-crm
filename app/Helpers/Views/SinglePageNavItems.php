<?php

namespace App\Helpers\Views;

class SinglePageNavItems
{
    public static function getProfileNavigationItems(): array
    {
        return [
            "user" => [
                "role" => "admin|cliente",
                "icon" => "user-circle",
                "routeName" => "settings.user",
                "label" => "Mi Usuario",
            ],
            "profile" => [
                "role" => "admin|cliente",
                "icon" => "user",
                "routeName" => "settings.profile",
                "label" => "Mi Perfil",
            ],
            "password" => [
                "role" => "admin|cliente",
                "icon" => "lock-closed",
                "routeName" => "settings.password",
                "label" => "Cambiar contraseña",
            ],
            "appearance" => [
                "role" => "admin|cliente",
                "icon" => "paint-brush",
                "routeName" => "settings.appearance",
                "label" => "Apariencia",
            ],
        ];
    }
}
