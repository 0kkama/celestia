import { Context } from '@nuxt/types';
import { setRequestClient } from '~/helpers/api';

// Состояние стора
let isAxiosInited = true;

export default function({ app, $axios }: Context): void {
    // Сбрасываем знание об инициализации, чтобы на сервер и клиенте проходила инициализация
    isAxiosInited = false;

    $axios.setBaseURL(process.server ? 'http://varnish' : document.location.origin);

    app.router?.afterEach(function() {
        if (!isAxiosInited) {
            isAxiosInited = true;

            setRequestClient($axios);
        }
    });
}
