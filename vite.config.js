import { defineConfig } from 'vite';

export default defineConfig({
    build: {
        outDir: 'assets/build',
        rollupOptions: {
            input: ['assets/app.js', 'assets/app.css'],
            output: {
                assetFileNames: (chunkInfo) => {
                    let outDir = '';
                    // Fonts
                    if (/(ttf|woff|woff2|eot)$/.test(chunkInfo.name)) {
                        outDir = 'fonts';
                        return `${outDir}/[name][extname]`;
                    }

                    // SVG
                    if (/svg$/.test(chunkInfo.name)) {
                        outDir = 'images/svg';
                    }

                    // images
                    if (/(png|jpg|jpeg|gif|webp)$/.test(chunkInfo.name)) {
                        outDir = 'images';
                    }

                    // js
                    if (/js$/.test(chunkInfo.name)) {
                        outDir = 'js';
                    }

                    // css
                    if (/css$/.test(chunkInfo.name)) {
                        outDir = 'css';
                    }

                    return `${outDir}/[name][extname]`;
                },

                entryFileNames: 'js/[name].js'
            }
        }
    }
});
