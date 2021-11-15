import { Module, VuexMutation, VuexModule, VuexAction } from 'nuxt-property-decorator';
import { MetaPropertyCharset, MetaPropertyEquiv, MetaPropertyName, MetaPropertyMicrodata, MetaPropertyProperty } from 'vue-meta';
import { PageData } from '~/models/Page';

interface PageState {
    // Поля стейта указываем с нижним подчёркиванием, чтобы названия не пересекались с экшенами и геттерами
    // Так же это сигнализирует что эти поля не являются публичными
    _data: PageData | null
    _raw: PageData | null
}

@Module({
    // Имя стора должно совпадать с именем файла
    name: 'page',

    // Эти два параметра обязательны. Без них работать не будет.
    stateFactory: true,
    namespaced: true
})
export default class PageStore extends VuexModule {
    private _data: PageState['_data'] = null;
    private _raw: PageState['_raw'] = null;

    @VuexMutation
    // Мутиации тоже указываем с `_`, чтобы не пересекалось с экшенами и геттерами
    // Не забываем указывать что это приватное поле `private`, чтобы извне не было возможности поменять данные
    private _update(payload: PageState['_raw']): void {
        this._raw = payload;
    }

    @VuexMutation
    private _reset(): void {
        this._raw = null;
    }

    @VuexMutation
    private _fix(): void {
        this._data = this._raw;
    }

    @VuexAction
    update(payload: PageState['_raw']): void {
        this._update(payload);
    }

    @VuexAction
    reset(): void {
        this._reset();
    }

    @VuexAction
    fix(): void {
        this._fix();
    }


    get data(): PageState['_data'] {
        return this._data;
    }

    get title(): string {
        if (this._data) {
            return this._data.title;
        }

        return '';
    }

    get metaTitle(): string {
        if (this._data) {
            return this._data.meta?.title || this._data.title;
        }

        return '';
    }

    get metaInfo(): (MetaPropertyCharset | MetaPropertyEquiv | MetaPropertyName | MetaPropertyMicrodata | MetaPropertyProperty)[] {
        if (!this._data) {
            return [];
        }

        return [
            { hid: 'description', name: 'description', content: this._data.meta?.description || '' },
            { hid: 'keywords', name: 'keywords', content: this._data.meta?.keywords || '' },
            { hid: 'og:title', name: 'og:title', content: this._data.meta?.title || '' },
            { hid: 'og:description', name: 'og:description', content: (this._data.meta?.description || '').replace(/<\/?[^>]+(>|$)/g, '') }
        ];
    }
}
