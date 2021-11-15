/* eslint-disable import/first */
/* eslint-disable import/no-mutable-exports */
import { Store } from 'vuex';
import { getModule } from 'nuxt-property-decorator';


// Убирает сервисные свойства, чтобы работа делалась через публичные методы интерфейса
type PublicModule<M> = Omit<M, 'modules' | 'state' | 'getters' | 'mutations' | 'namespaced' | 'actions' | 'context'>;

// Каждый стор необходимо указывать с типом
// Объявляем переменную и сразу экспортируем её. После будем импортировать стор отсюда.
// Не присваивайте значение здесь! Это делается в initStore.
import PageStore from './page';
export let pageStore: PublicModule<PageStore>;


export const initStore = (store: Store<any>): void => {
    // Для каждого стора, нужно написать получение модуля.
    // Просто копируйте строку, подменяйте названия и всё будет хорошо :-)
    pageStore = getModule(PageStore, store);
};
