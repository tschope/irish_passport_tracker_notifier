// https://nuxt.com/docs/api/configuration/nuxt-config
const path = require('path');
export default defineNuxtConfig({
    app: {
      head: {
          title: process.env.APP_NAME,
          charset: 'utf-8',
          viewport: 'width=device-width, initial-scale=1',
          link: [
              { rel: 'apple-touch-icon', sizes: '57x57', href: '/apple-icon-57x57.png' },
              { rel: 'apple-touch-icon', sizes: '60x60', href: '/apple-icon-60x60.png' },
              { rel: 'apple-touch-icon', sizes: '72x72', href: '/apple-icon-72x72.png' },
              { rel: 'apple-touch-icon', sizes: '76x76', href: '/apple-icon-76x76.png' },
              { rel: 'apple-touch-icon', sizes: '114x114', href: '/apple-icon-114x114.png' },
              { rel: 'apple-touch-icon', sizes: '120x120', href: '/apple-icon-120x120.png' },
              { rel: 'apple-touch-icon', sizes: '144x144', href: '/apple-icon-144x144.png' },
              { rel: 'apple-touch-icon', sizes: '152x152', href: '/apple-icon-152x152.png' },
              { rel: 'apple-touch-icon', sizes: '180x180', href: '/apple-icon-180x180.png' },

              { rel: 'icon', type: 'image/png', sizes: '192x192', href: '/android-icon-192x192.png' },
              { rel: 'icon', type: 'image/png', sizes: '32x32', href: '/favicon-32x32.png' },
              { rel: 'icon', type: 'image/png', sizes: '96x96', href: '/favicon-96x96.png' },
              { rel: 'icon', type: 'image/png', sizes: '16x16', href: '/favicon-16x16.png' },

              { rel: 'manifest', href: '/manifest.json' },
          ],
          meta: [
              { name: 'msapplication-TileColor', content: '#ffffff' },
              { name: 'msapplication-TileImage', content: '/ms-icon-144x144.png' },
              { name: 'theme-color', content: '#ffffff' },
              { name: 'description', content: 'This website helps you stay updated about your Irish Passport application. Enter your Application ID, Email, choose the times you\'d like to receive notifications, and let us keep you informed via email updates.', },
              { name: 'ogDescription', content: 'This website helps you stay updated about your Irish Passport application. Enter your Application ID, Email, choose the times you\'d like to receive notifications, and let us keep you informed via email updates.', },
              { name: 'ogTitle', content: process.env.APP_NAME },
              { name: 'ogImage', content: 'https://opengraph.b-cdn.net/production/images/384a9630-5979-4ef7-8822-f8702216f985.png?token=6gAdbZGEOjmXrlzu2NancDQSdDzxG0-nZycXqz1_D9E&height=362&width=867&expires=33273561833' },
              { name: 'ogUrl', content: process.env.APP_URL },
              { name: 'ogType', content: 'website' },
              { name: 'twitter:card', content: 'summary_large_image' },
              { property: 'twitter:domain', content: process.env.APP_URL },
              { property: 'twitter:url', content: process.env.APP_URL },
              { name: 'twitter:title', content: process.env.APP_NAME },
              { name: 'twitter:description', content: 'This website helps you stay updated about your Irish Passport application. Enter your Application ID, Email, choose the times you\'d like to receive notifications, and let us keep you informed via email updates.' },
              { name: 'twitter:image', content: 'https://opengraph.b-cdn.net/production/images/384a9630-5979-4ef7-8822-f8702216f985.png?token=6gAdbZGEOjmXrlzu2NancDQSdDzxG0-nZycXqz1_D9E&height=362&width=867&expires=33273561833' },

          ],
      }
    },

    modules: ['nuxt-gtag', '@nuxtjs/seo', '@nuxtjs/sitemap'],

    gtag: {
        enabled: process.env.NODE_ENV === 'production',
        id: process.env.NUXT_PUBLIC_GTAG_ID || 'G-xxxxxxxxx', // Valor padrão para fallback
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
          apiBase: process.env.API_BASE_URL + '/api' || 'http://localhost:3000', // Valor padrão para fallback
      },
    },

    site: {
        url: 'https://example.com',
        name: 'Irish Passport E-mail Notifier',
        description: 'This website helps you stay updated about your Irish Passport application.\n' +
            '            Enter your Application ID, Email, choose the times you\'d like to receive notifications,\n' +
            '            and let us keep you informed via email updates.',
        defaultLocale: 'en', // not needed if you have @nuxtjs/i18n installed
    }
})
