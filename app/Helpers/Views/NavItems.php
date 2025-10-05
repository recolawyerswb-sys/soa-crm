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
                "role" => "admin|agent",
                "items" => [
                    // CLIENTES
                    [
                        "routeName" => "business.customers.index",
                        "label" => "Clientes",
                        "icon" => "users",
                        "canSee" => "admin|agent|agent-lead",
                    ],
                    // AGENTES
                    [
                        "routeName" => "business.agents.index",
                        "label" => "Agentes",
                        "icon" => "briefcase",
                        "canSee" => "admin|agent-lead",
                    ],
                    // EQUIPOS
                    [
                        "routeName" => "business.teams.index",
                        "label" => "Equipos",
                        "icon" => "user-group",
                        "canSee" => "admin|agent-lead",
                    ],
                    // ASIGNACIONES
                    [
                        "routeName" => "business.assignments.index",
                        "label" => "Asignaciones",
                        "icon" => "arrow-uturn-up",
                        "canSee" => "admin|agent|agent-lead",
                    ],
                    // SEGUIMIENTOS
                    [
                        "routeName" => "business.client-tracking.index",
                        "label" => "Seguimientos",
                        "icon" => "signal",
                        "canSee" => "admin|agent|agent-lead",
                    ],
                ],
            ],
            "administracion" => [
                "isGroup" => true,
                "icon" => "cog-6-tooth",
                "heading" => "Administrativo",
                "role" => "admin|manager",
                "items" => [
                    // ROLES Y PERMISOS
                    [
                        "routeName" => "business.access-control.index",
                        "label" => "Roles y permisos",
                        "icon" => "shield-check",
                        "canSee" => "admin|manager",
                    ],
                ],
            ],
            "llamadas" => [
                "isGroup" => true,
                "icon" => "phone",
                "heading" => "Llamadas",
                "role" => "admin|agent|agent-leader",
                "items" => [
                    // [
                    //     "routeName" => "sells.calls.index",
                    //     "label" => "Historial",
                    //     "icon" => "phone",
                    //     "canSee" => "admin|agent|agent-lead",
                    // ],
                    [
                        "routeName" => "sells.calls.history",
                        "label" => "Historial",
                        "icon" => "clock",
                        "canSee" => "admin",
                    ],
                    // [
                    //     "routeName" => "sells.calls.test",
                    //     "label" => "Pruebas",
                    //     "icon" => "beaker",
                    //     "canSee" => "admin",
                    // ],
                    [
                        "routeName" => "sells.calls.reports",
                        "label" => "Reportes",
                        "icon" => "chart-pie",
                        "canSee" => "admin",
                    ],
                ],
            ],
            "cuentasMovimientos" => [
                "isGroup" => true,
                "icon" => "banknotes",
                "heading" => "Cuentas y movimientos",
                "role" => "admin|customer",
                "items" => [
                    [
                        "routeName" => "wallet.index",
                        "label" => "Wallets",
                        "icon" => "currency-dollar",
                        "canSee" => "admin|banki",
                    ],
                    [
                        "routeName" => "wallet.movements.index",
                        "label" => auth()->user()->isCliente() ? "Mis movimientos" : "Movimientos",
                        "icon" => "banknotes",
                        "canSee" => "admin|customer",
                    ],
                ],
            ],
        ];
    }
}
