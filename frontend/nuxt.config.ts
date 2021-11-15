import { NuxtConfig } from '@nuxt/types';

const isProduction = process.env.NODE_ENV === 'production';


const config: NuxtConfig = {
    telemetry: false,

    /*
    ** Build configuration
    ** See https://nuxtjs.org/api/configuration-build/
    */
    build: {
        parallel: true,
        postcss: {
            plugins: {
                cssnano: isProduction ? { preset: 'default' } : false,
                'postcss-nesting': {}
            },
            preset: {
                autoprefixer: {
                    grid: isProduction ? 'autoplace' : false
                }
            }
        }
    },

    /*
    ** Nuxt target
    ** See https://nuxtjs.org/api/configuration-target
    */
    target: 'server',

    /*
    ** Headers of the page
    ** See https://nuxtjs.org/api/configuration-head
    */
    head() {
        if (process.server) {
            // meta.push({ hid: 'og:image', name: 'og:image', content: `//${ this.context.req.headers.host }/social.jpg` });
        }

        return {
            title: this.$store.getters['page/metaTitle'] || 'App',
            meta: [
                { charset: 'utf-8' },
                { name: 'viewport', content: 'width=device-width, initial-scale=1' },
                ...this.$store.getters['page/metaInfo']
                // ...meta
            ],
            link: [
                { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' }
            ]
        };
    },

    /*
    ** Global CSS
    */
    css: [],

    /*
    ** Plugins to load before mounting the App
    ** https://nuxtjs.org/guide/plugins
    */
    plugins: [
        '~/plugins/store',
        '~/plugins/axios.ts',
        '~/plugins/page.ts',
        '~/plugins/layer/layer.client.js',
        '~/plugins/storage.js',
        '~/plugins/uuid.ts'
    ],

    /*
    ** Auto import components
    ** See https://nuxtjs.org/api/configuration-components
    */
    components: [
        '~/components',
        { path: '~/components/layers/', global: true }
    ],

    /*
    ** Nuxt.js dev-modules
    */
    buildModules: [
        '@nuxt/typescript-build',
        // Doc: https://github.com/nuxt-community/eslint-module
        '@nuxtjs/eslint-module',
        '@nuxtjs/tailwindcss',
        '@nuxtjs/svg'
    ],

    /*
    ** Nuxt.js modules
    */
    modules: [
        // Doc: https://axios.nuxtjs.org/usage
        '@nuxtjs/axios',
        'nuxt-user-agent',
        '@nuxtjs/sentry'
    ],

    /*
    ** Axios module configuration
    ** See https://axios.nuxtjs.org/options
    */
    axios: {},

    /** Инструкция — https://nuxtjs.org/docs/2.x/configuration-glossary/configuration-router */
    router: {
        middleware: ['page'],
        trailingSlash: true,
        prefetchLinks: false
    },

    sentry: {
        dsn: process.env.SSR_SENTRY_DSN || process.env.CLIENT_SENTRY_DSN || '',
        clientConfig: {
            dsn: process.env.CLIENT_SENTRY_DSN || ''
        }
    },

    tailwindcss: {
        /** Все глобальные стили, включая Tailwind, подключаем на все страницы проекта. */
        cssPath: '~/assets/styles/global.css',

        /** Просмотрщик работает только в режиме разработки → `nuxt dev` */
        viewer: true,

        /**
         * Включить, если нужно использовать значения конфига в скриптах.
         *
         * {@link https://tailwindcss.nuxtjs.org/tailwind/config#referencing-in-the-application Инструкция}
         */
        exposeConfig: false,

        /**
         * Новый режим сборки.
         *
         * {@link https://tailwindcss.com/docs/just-in-time-mode Инструкция}
         */
        jit: true
    }
};


export default config;
