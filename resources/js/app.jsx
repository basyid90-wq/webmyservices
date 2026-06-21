import { createInertiaApp } from '@inertiajs/react';
import { createRoot } from 'react-dom/client';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';

const el = document.getElementById('app');

createInertiaApp({
    resolve: (name) => {
        console.log('Inertia resolving:', name);
        return resolvePageComponent(
            `./Pages/${name}.jsx`,
            import.meta.glob('./Pages/**/*.jsx'),
        );
    },
    setup({ el, App, props }) {
        createRoot(el).render(<App {...props} />);
    },
    progress: {
        color: '#6366f1',
    },
}).catch(err => {
    console.error('Inertia init failed:', err);
    if (el) {
        el.innerHTML = `<div style="padding:40px;color:red;background:white;font-family:monospace;min-height:100vh"><h1>JS Error</h1><pre>${err.message}\n${err.stack}</pre></div>`;
    }
});
