/**
 * Баг с JIT
 *
 * Иногда стили не обновляются при изменении конфига.
 * Помогает запустить пересборку стилей через сохранение `global.css`
 */

module.exports = {
    corePlugins: {
        container: false
    },

    /**
     * Не создавайте варианты!
     * Все варианты доступны сразу, если работает JIT режим.
     *
     * {@link https://tailwindcss.com/docs/just-in-time-mode#all-variants-are-enabled Документация}
     */
    // variants: {},

    plugins: [
        /**
         * Хелперы для создания блоков с предустановленным соотношением сторон
         * {@link https://github.com/tailwindlabs/tailwindcss-aspect-ratio Инструкция}
         */
        require('@tailwindcss/aspect-ratio'),

        /**
         * Многострочное троеточие
         * {@link https://github.com/tailwindlabs/tailwindcss-line-clamp Инструкция}
         */
        require('@tailwindcss/line-clamp')
    ],

    theme: {
        extend: {
            fontSize: {
            },
            colors: {
            },
            spacing: {
            }
        },
        fontFamily: {
        },
        screens: {
            xl: { max: '1200px' },
            lg: { max: '1000px' },
            md: { max: '750px' },
            sm: { max: '600px' },
            'a-sm': { min: '601px' },
            'a-md': { min: '751px' },
            'a-lg': { min: '1001px' },
            'a-xl': { min: '1201px' }
        }
    },
    purge: {
        enabled: process.env.NODE_ENV === 'production',

        /**
         * Это свойство неработает с JIT режимом.
         * Указывайте необходимые классы в `tailwind-safelist.txt`.
         *
         * {@link https://tailwindcss.com/docs/just-in-time-mode#known-limitations}
         */
        // safelist: [],

        content: [
            /**
             * Здесь указывать набор CSS классов Tailwind, которые приходят с бэка.
             * Все стили написанные в <style> или через `import` не будут резаться, поэтому не добавляйте туда ничего кроме tailwind классов.
             *
             * {@link https://tailwindcss.com/docs/just-in-time-mode#known-limitations}
             */
            './assets/styles/tailwind-safelist.txt',

            './components/**/*.vue',
            './layouts/**/*.vue',
            './pages/**/*.vue',
            './mixins/**/*.{js,ts}',
            './helpers/**/*.{js,ts}',
            './plugins/**/*.{js,ts}',
            './nuxt.config.{js,ts}'
        ]
    }
};
