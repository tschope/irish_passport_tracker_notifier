// https://nuxt.com/docs/api/configuration/nuxt-config
const path = require('path');
export default defineNuxtConfig({
    app: {
      head: {
          title: process.env.APP_NAME,
          charset: 'utf-8',
          viewport: 'width=device-width, initial-scale=1',
          link: [
              // Ícones para dispositivos Apple
              { rel: 'apple-touch-icon', sizes: '57x57', href: '/_nuxt/assets/images/apple-icon-57x57.png' },
              { rel: 'apple-touch-icon', sizes: '60x60', href: '/_nuxt/assets/images/apple-icon-60x60.png' },
              { rel: 'apple-touch-icon', sizes: '72x72', href: '/_nuxt/assets/images/apple-icon-72x72.png' },
              { rel: 'apple-touch-icon', sizes: '76x76', href: '/_nuxt/assets/images/apple-icon-76x76.png' },
              { rel: 'apple-touch-icon', sizes: '114x114', href: '/_nuxt/assets/images/apple-icon-114x114.png' },
              { rel: 'apple-touch-icon', sizes: '120x120', href: '/_nuxt/assets/images/apple-icon-120x120.png' },
              { rel: 'apple-touch-icon', sizes: '144x144', href: '/_nuxt/assets/images/apple-icon-144x144.png' },
              { rel: 'apple-touch-icon', sizes: '152x152', href: '/_nuxt/assets/images/apple-icon-152x152.png' },
              { rel: 'apple-touch-icon', sizes: '180x180', href: '/_nuxt/assets/images/apple-icon-180x180.png' },

              // Ícones para Android
              { rel: 'icon', type: 'image/png', sizes: '192x192', href: '/_nuxt/assets/images/android-icon-192x192.png' },
              { rel: 'icon', type: 'image/png', sizes: '32x32', href: '/_nuxt/assets/images/favicon-32x32.png' },
              { rel: 'icon', type: 'image/png', sizes: '96x96', href: '/_nuxt/assets/images/favicon-96x96.png' },
              { rel: 'icon', type: 'image/png', sizes: '16x16', href: '/_nuxt/assets/images/favicon-16x16.png' },

              // Manifest
              { rel: 'manifest', href: '/manifest.json' },
          ],
          meta: [
              // Meta tags
              { name: 'msapplication-TileColor', content: '#ffffff' },
              { name: 'msapplication-TileImage', content: '/_nuxt/assets/images/ms-icon-144x144.png' },
              { name: 'theme-color', content: '#ffffff' }
          ],
      }
    },

    modules: ['nuxt-gtag'],

    gtag: {
        enabled: process.env.NODE_ENV === 'production',
        id: 'G-XXXXXXXXXX',
    },

    compatibilityDate: '2024-11-01',
    devtools: { enabled: true },

    // Ativa o modo SSR
    ssr: true,

    nitro: {
      preset: 'node-server', // Gera uma aplicação pronta para Node.js
    },

    css: ['~/assets/css/main.css'],

    postcss: {
      plugins: {
          tailwindcss: {},
          autoprefixer: {},
      },
    },

    runtimeConfig: {
      public: {
          apiBase: process.env.API_BASE_URL || 'http://localhost:3000', // Valor padrão para fallback
      },
    },
})
