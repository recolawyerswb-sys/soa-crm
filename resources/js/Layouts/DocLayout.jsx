import React, { useState, useEffect } from 'react';
import { Link, Head, usePage } from '@inertiajs/react';

// Un ícono simple de Sol y Luna para el switcher
const SunIcon = () => <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" className="w-6 h-6"><path strokeLinecap="round" strokeLinejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-6.364-.386l1.591-1.591M3 12h2.25m.386-6.364l1.591 1.591" /></svg>;
const MoonIcon = () => <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" className="w-6 h-6"><path strokeLinecap="round" strokeLinejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" /></svg>;


export default function DocLayout({ children, title }) {
    // Hook para acceder a los props compartidos, como 'auth'
    const { auth } = usePage().props;

    console.log(auth);

    // Lógica para el Theme Switcher
    const [isDarkMode, setIsDarkMode] = useState(() => {
        if (typeof window !== 'undefined') {
            return localStorage.getItem('theme') === 'dark' ||
                   (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches);
        }
        return false;
    });

    useEffect(() => {
        if (isDarkMode) {
            document.documentElement.classList.add('dark');
            localStorage.setItem('theme', 'dark');
        } else {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('theme', 'light');
        }
    }, [isDarkMode]);

    const toggleTheme = () => {
        setIsDarkMode(prevMode => !prevMode);
    };

    return (
        <div className="bg-gray-100 dark:bg-gray-900 min-h-screen text-gray-800 dark:text-gray-200">
            {/* El componente Head nos permite establecer el título de la página dinámicamente */}
            <Head title={title} />

            {/* Barra de Navegación */}
            <nav className="bg-white dark:bg-gray-800 shadow-md">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="flex items-center justify-between h-16">
                        {/* Logo o Nombre de la App */}
                        <div className="flex-shrink-0">
                            <Link href="/" className="text-xl font-bold text-indigo-600 dark:text-indigo-300">
                                SOA Crm | Centro de Ayuda
                            </Link>
                        </div>

                        {/* Contenedor de botones a la derecha */}
                        <div className="flex items-center space-x-4">
                            {/* Theme Switcher */}
                            <button onClick={toggleTheme} className="p-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                                {isDarkMode ? <SunIcon /> : <MoonIcon />}
                            </button>

                            {/* Renderizado Condicional de Botones */}
                            {auth.check ? (
                                // Si el usuario ESTÁ autenticado
                                <div className="flex items-center space-x-4">
                                    <span>Hola, {auth.user.name}</span>
                                    <a href="/crm" className="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400">CRM</a>
                                    <a href="/logout" method="post" as="button" className="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400">Salir</a>
                                </div>
                            ) : (
                                // Si el usuario NO ESTÁ autenticado
                                <div className="flex items-center space-x-2">
                                    <a href="/login" className="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-100 dark:hover:bg-gray-700">
                                        Login
                                    </a>
                                    <a href="/register" className="px-3 py-2 rounded-md text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                                        Sign Up
                                    </a>
                                </div>
                            )}
                        </div>
                    </div>
                </div>
            </nav>

            {/* Contenido Principal de la Página */}
            <main>
                {children}
            </main>
        </div>
    );
}
