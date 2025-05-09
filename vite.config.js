import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { networkInterfaces } from 'os';

// Função para pegar automaticamente o IP da rede local
function getLocalIP() {
    const nets = networkInterfaces();
    for (const name of Object.keys(nets)) {
      for (const net of nets[name]) {
        if (net.family === 'IPv4' && !net.internal && name.startsWith('wlo') || name.startsWith('eth')) {
          return net.address;
        }
      }
    }
    return 'localhost'; // Fallback
}

const localIP = getLocalIP();

export default defineConfig({
    // Define o caminho base para o Vite
    // acesso pela rede local
    server: {
        host: '0.0.0.0',
        port: 5173,
        strictPort: true,
        hmr: {
          host: localIP, // IP detectado automaticamente
        },
    },
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
