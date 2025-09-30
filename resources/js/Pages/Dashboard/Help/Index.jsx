import React, { useState, useEffect, useRef } from 'react';
import { usePage } from '@inertiajs/react';
import DocLayout from '@/Layouts/DocLayout';

// Pequeño componente para renderizar el contenido dinámicamente
const ContentRenderer = ({ item }) => {
    switch (item.type) {
        // NUEVO: Renderiza un encabezado H2
        case 'heading':
            return <h2 className="text-2xl font-bold text-gray-800 dark:text-white mt-8 mb-4">{item.text}</h2>;

        // NUEVO: Renderiza un subtítulo H3
        case 'subheading':
            return <h3 className="text-xl font-semibold text-gray-700 dark:text-gray-300 mt-6 mb-3">{item.text}</h3>;

        case 'paragraph':
            return <p className="text-base lg:text-lg text-gray-700 dark:text-gray-300 mb-4 leading-relaxed">{item.text}</p>;

        // MODIFICADO: Renderiza <ol> o <ul> según la propiedad 'listType'
        case 'list':
            const ListComponent = item.listType === 'ol' ? 'ol' : 'ul';
            const listStyle = item.listType === 'ol' ? 'list-decimal' : 'list-disc';

            return (
                <ListComponent className={`${listStyle} list-inside space-y-2 mb-4 pl-4`}>
                    {item.items.map((li, index) => (
                        <li key={index} className="text-base lg:text-lg text-gray-700 dark:text-gray-300">{li}</li>
                    ))}
                </ListComponent>
            );

        case 'code':
            return (
                <pre className="bg-gray-100 dark:bg-gray-800 p-4 rounded-lg my-4 overflow-x-auto">
                    <code className="font-mono text-sm text-gray-800 dark:text-gray-200">{item.text}</code>
                </pre>
            );

        default:
            return null;
    }
};

export default function HelpPage({ sections }) {
    // Obtenemos el rol del usuario actual desde los props globales
    const { auth } = usePage().props;
    const userRole = auth.rol;

    // Filtramos las secciones ANTES de renderizar
    const visibleSections = sections.filter(section => {
        // 1. Si la sección no tiene 'canRead', es pública. Mostrar siempre.
        if (!section.canRead) {
            return true;
        }

        // 2. Si el usuario no tiene un rol (no está logueado), no puede ver secciones protegidas.
        if (!userRole) {
            return false;
        }

        // 3. Comprobar si el rol del usuario está en la lista de roles permitidos.
        const allowedRoles = section.canRead.split('|');
        return allowedRoles.includes(userRole);
    });

    const [activeSection, setActiveSection] = useState(visibleSections[0]?.id || '');
    const sectionRefs = useRef({});

    // Efecto para observar qué sección está visible en la pantalla
    useEffect(() => {
        const observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        setActiveSection(entry.target.id);
                    }
                });
            },
            { rootMargin: '-20% 0px -80% 0px' } // Activa cuando la sección está en el 20% superior de la pantalla
        );

        Object.values(sectionRefs.current).forEach(section => {
            if (section) observer.observe(section);
        });

        return () => {
            Object.values(sectionRefs.current).forEach(section => {
                if (section) observer.unobserve(section);
            });
        };
    }, [visibleSections]);

    const scrollToSection = (id) => {
        sectionRefs.current[id]?.scrollIntoView({ behavior: 'smooth', block: 'start' });
    };

    return (
        <>
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div className="flex flex-col lg:flex-row py-8 lg:py-16">

                    {/* Menú de Navegación Lateral */}
                    <aside className="lg:w-1/4 lg:pr-8 mb-8 lg:mb-0">
                        <div className="sticky top-24">
                            <h2 className="text-sm font-bold uppercase tracking-widest text-gray-500 dark:text-gray-400 mb-4">Secciones</h2>
                            <nav className="flex flex-col space-y-2">
                                {visibleSections.map(section => (
                                    <a
                                        key={section.id}
                                        href={`#${section.id}`}
                                        onClick={(e) => {
                                            e.preventDefault();
                                            scrollToSection(section.id);
                                        }}
                                        className={`px-3 py-2 rounded-md text-base transition-colors duration-200 ${
                                            activeSection === section.id
                                                ? 'bg-blue-50 dark:bg-blue-900/50 text-blue-600 dark:text-blue-300 font-semibold'
                                                : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800'
                                        }`}
                                    >
                                        {section.title}
                                    </a>
                                ))}
                            </nav>
                        </div>
                    </aside>

                    {/* Contenido Principal */}
                    <main className="lg:w-3/4">
                        {visibleSections.map(section => (
                            <section
                                key={section.id}
                                id={section.id}
                                ref={el => (sectionRefs.current[section.id] = el)}
                                className="mb-12 scroll-mt-24" // scroll-mt-24 para dar espacio al hacer scroll
                            >
                                <h1 className="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-6 pb-2 border-b border-gray-200 dark:border-gray-700">
                                    {section.title}
                                </h1>
                                <div>
                                    {section.content.map((item, index) => (
                                        <ContentRenderer key={index} item={item} />
                                    ))}
                                </div>
                            </section>
                        ))}
                    </main>
                </div>
            </div>
        </>
    );
}

// 2. Asigna el layout a la página
HelpPage.layout = page => <DocLayout children={page} title="Centro de Ayuda" />
