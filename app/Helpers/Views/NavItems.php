<?php

namespace App\Helpers\Views;

class NavItems extends SinglePageNavItems
{
    public static function getNavigationItems(): array
    {
        return $items = [
            // ADMIN NAVIGATION ITEMS
            "negocio" => [
                "isGroup" => true,
                "icon" => "building-storefront",
                "heading" => "Negocio",
                "role" => "admin|agente",
                "items" => [
                    // CLIENTES
                    [
                        "routeName" => "business.customers.index",
                        "label" => "Clientes",
                        "icon" => "users",
                    ],
                    // AGENTES
                    [
                        "routeName" => "business.agents.index",
                        "label" => "Agentes",
                        "icon" => "briefcase",
                    ],
                    // EQUIPOS
                    [
                        "routeName" => "business.teams.index",
                        "label" => "Equipos",
                        "icon" => "user-group",
                    ],
                    // ASIGNACIONES
                    [
                        "routeName" => "business.assignments.index",
                        "label" => "Asignaciones",
                        "icon" => "arrow-uturn-up",
                    ],
                ],
            ],
            "administracion" => [
                "isGroup" => true,
                "icon" => "cog-6-tooth",
                "heading" => "Administrativo",
                "role" => "admin",
                "items" => [
                    // ROLES Y PERMISOS
                    [
                        "routeName" => "business.access-control.index",
                        "label" => "Roles y permisos",
                        "icon" => "shield-check",
                    ],
                ],
            ],
            "llamadas" => [
                "isGroup" => true,
                "icon" => "phone",
                "heading" => "Llamadas",
                "role" => "admin|agent|agent-leader",
                "items" => [
                    [
                        "routeName" => "sells.calls.index",
                        "label" => "Historial",
                        "icon" => "phone",
                    ],
                    [
                        "routeName" => "sells.calls.test",
                        "label" => "Pruebas",
                        "icon" => "beaker",
                    ],
                    [
                        "routeName" => "sells.calls.reports",
                        "label" => "Reportes",
                        "icon" => "chart-pie",
                    ],
                ],
            ],
            "cuentasMovimientos" => [
                "isGroup" => true,
                "icon" => "banknotes",
                "heading" => "Movimientos",
                "role" => "admin|cliente",
                "items" => [
                    [
                        "routeName" => "wallet.index",
                        "label" => "Cuentas",
                        "icon" => "currency-dollar",
                    ],
                    [
                        "routeName" => "wallet.movements.index",
                        "label" => "Movimientos",
                        "icon" => "banknotes",
                    ],
                ],
            ],
        ];
    }
}
