<?php

namespace App\Helpers\Views;

class SinglePageNavItems
{
    public static function getProfileNavigationItems(): array
    {
        return [
            "user" => [
                "role" => "developer|admin|agent|banki|manager|cliente",
                "icon" => "user-circle",
                "routeName" => "settings.user",
                "label" => "Mi Usuario",
            ],
            "profile" => [
                "role" => "developer|admin|agent|banki|manager|cliente",
                "icon" => "user",
                "routeName" => "settings.profile",
                "label" => "Mi Perfil",
            ],
            "password" => [
                "role" => "developer|admin|cliente",
                "icon" => "lock-closed",
                "routeName" => "settings.password",
                "label" => "Cambiar contraseña",
            ],
            // "appearance" => [
            //     "role" => "developer|admin|agent|banki|manager|cliente",
            //     "icon" => "paint-brush",
            //     "routeName" => "settings.appearance",
            //     "label" => "Apariencia",
            // ],
        ];
    }
}
