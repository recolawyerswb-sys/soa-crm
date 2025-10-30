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
                "role" => "developer|admin|agent",
                "items" => [
                    // CLIENTES
                    [
                        "routeName" => "business.customers.index",
                        "label" => "Clientes",
                        "icon" => "users",
                        "canSee" => "developer|admin|agent|agent-lead",
                    ],
                    // AGENTES
                    [
                        "routeName" => "business.agents.index",
                        "label" => "Agentes",
                        "icon" => "briefcase",
                        "canSee" => "developer|admin|agent-lead",
                    ],
                    // EQUIPOS
                    [
                        "routeName" => "business.teams.index",
                        "label" => "Equipos",
                        "icon" => "user-group",
                        "canSee" => "developer|admin|agent-lead",
                    ],
                    // ASIGNACIONES
                    [
                        "routeName" => "business.assignments.index",
                        "label" => "Asignaciones",
                        "icon" => "arrow-uturn-up",
                        "canSee" => "developer|admin|agent|agent-lead",
                    ],
                    // SEGUIMIENTOS
                    [
                        "routeName" => "business.client-tracking.index",
                        "label" => "Seguimientos",
                        "icon" => "signal",
                        "canSee" => "developer|admin|agent|agent-lead",
                    ],
                ],
            ],
            "administracion" => [
                "isGroup" => true,
                "icon" => "cog-6-tooth",
                "heading" => "Administrativo",
                "role" => "developer|admin|manager",
                "items" => [
                    // ROLES Y PERMISOS
                    [
                        "routeName" => "business.access-control.roles-permissions",
                        "label" => "Roles y permisos",
                        "icon" => "shield-check",
                        "canSee" => "developer",
                    ],
                    [
                        "routeName" => "business.access-control.users",
                        "label" => "Usuarios",
                        "icon" => "user-circle",
                        "canSee" => "developer|admin",
                    ],
                ],
            ],
            "llamadas" => [
                "isGroup" => true,
                "icon" => "phone",
                "heading" => "Llamadas",
                "role" => "developer|admin",
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
                        "canSee" => "developer|admin",
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
                        "canSee" => "developer|admin",
                    ],
                ],
            ],
            "cuentasMovimientos" => [
                "isGroup" => true,
                "icon" => "banknotes",
                "heading" => "Cuentas y movimientos",
                "role" => "developer|admin|customer",
                "items" => [
                    [
                        "routeName" => "wallet.index",
                        "label" => "Wallets",
                        "icon" => "currency-dollar",
                        "canSee" => "developer|admin|banki",
                    ],
                    [
                        "routeName" => "wallet.movements.index",
                        "label" => auth()->user()->isCliente() ? "Movimientos Universales" : "Movimientos",
                        "icon" => "banknotes",
                        "canSee" => "developer|admin|banki|customer",
                    ],
                ],
            ],
            "testing" => [
                "isGroup" => true,
                "icon" => "phone",
                "heading" => "Testing y correciones",
                "role" => "developer",
                "items" => [
                    [
                        "routeName" => "testing.correct.modals",
                        "label" => "Modales",
                        "icon" => "cog",
                        "canSee" => "developer",
                    ],
                ],
            ],
        ];
    }
}
