import form from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */

export default {
    important: true,
    content: ['./assets/**/*.{js,ts,vue,jsx,tsx}', './includes/**/*.{php,html}', './views/**/*.{php,html}'],
    theme: {
        extend: {}
    },
    plugins: [form]
};
