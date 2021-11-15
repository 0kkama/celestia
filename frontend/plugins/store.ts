import { Context } from '@nuxt/types';
import { initStore } from '~/store';

// Состояние стора
let isStoreInited = true;

export default function({ app, store }: Context): void {
    // Сбрасываем знание об инициализации, чтобы на сервер и клиенте проходила инициализация
    isStoreInited = false;

    // Чтобы в нужный период времени проставлялся корректный Vuex стор
    // Обязательно это должно быть в хуке роутера `afterEach`, потому что только он срабатывает на сервере и клиенте предсказуемо в одно время — до всех плагинов и мидлваров
    app.router?.afterEach(function() {
        if (!isStoreInited) {
            isStoreInited = true;

            initStore(store);
        }
    });
}
