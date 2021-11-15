# [WIP] Typescript

Здесь описаны общие положения касательно того как писать и пользоваться TS.

Все новые проекты использовать будут только TS. Поэтому писать `.js` расширения считается зазорным и будет высмеиваться.

**Как работать с TS во фреймворках**

- [Vue](../vue/typescript.md)
- React (todo)
- Angular (todo)

**Полезные ссылки**

1. [Документация, оф. сайт](https://www.typescriptlang.org/docs/)
2. [Краткое введение в TS](https://www.typescriptlang.org/docs/handbook/typescript-in-5-minutes.html)
3. [Справочник](https://www.typescriptlang.org/docs/handbook/intro.html)

[[_TOC_]]



## Зачем нам использовать Typescript

Главная проблема которую мы хотим решить TS — поддержка кода. А это значит что нам нужен предсказуемый и документированный код. JSDoc никто не хочет писать и поддерживать, поэтому следующий шаг — типизированный вариант JS.

Так же, описывая типы и интерфейсы, избежим базовых ошибок в коде — неверный формат переданных данных в функцию и неожиданый результат метода.

Плюс код теперь будет точно документированным и не придётся изучать все 50 строк кода, чтобы понять что метод возвращает строку. Это нас спасёт на поддержке проектов, когда через год надо будет разобраться что происходит.



## Правила пользования

### Не используем `any` 

Если вы не знаете что делает ваш метод или какие данные должны быть в интерфейсе, не пишите что там `any` может быть. 

**Плохо**
Разработчик не понимает что делает его функция. Пишет говнохак в виде `any`.

```typescript
function doSomething(): any {
	if (isThisTypescript) {
		return 'cool';
	}
	return 0;
}
```

**Хорошо**
Разработчик знает что происходит внутри функции и что будет отдано в результате.

```typescript
function doSomething(): string|number {
	if (isThisTypescript) {
		return 'cool';
	}
	return 0;
}
```

------

###  `type` или `interface`

`type` — тип данных, с которым будет сравнение.
`interface` — формат объекта, который необходимо реализовать.

Если вы будете описывать объекты данных — почти всегда это будет `interface`.
Если вам надо создать набор форматов или алиасы для типов — это похоже на `type`.

[Объяснение с оф. сайта](https://www.typescriptlang.org/docs/handbook/2/everyday-types.html#differences-between-type-aliases-and-interfaces)

---

### Внешние и глобальные типы

Используя глобальные библиотеки скриптов написанных на JS, часто придётся устанавливать типы отдельно. Например, на Vue+Nuxt проектах установлен такой набор `@nuxt/types`. Без него интерфейс Nuxt окружения не будет типизирован.

Но недостаточно установить пакет типов, надо его ещё подключить. Это делается в файле `frontend/tsconfig.json` в поле `types`:

```json
// file: frontend/tsconfig.json

{
    "compilerOptions": {
        ...
        "types": [
            "@types/node",
            "@nuxt/types",
            "@nuxtjs/axios"
        ]
    },
    "exclude": [
        "node_modules",
        ".nuxt",
    ]
}

```

[**Документация по конфигу**](https://www.typescriptlang.org/tsconfig#types)

---

### Локальные типы

На проекте существуют не только типы для пакетов, но и для данных и других интерфейсов. У нас есть три варианта где их описывать — папка `types`, папка `models` и внутри файла.

- [Про расширение файла `.d.ts`](https://www.typescriptlang.org/docs/handbook/2/type-declarations.html#dts-files)

#### Папка `types` — общие типы и модификация глобальных модулей

Внутри этой папки должны находиться расширения для глобальных модулей. Например, чтобы добавить знание о том что у нас есть `$layer` свойство у инстанса Vue:

```typescript
// Vue:file: frontend/types/plugins/layer.d.ts

export interface LayerInterface {
    open<T = any>(props?: Record<string, unknown>): Promise<T>
    close<T = any>(props?: Record<string, unknown>): Promise<T>
    alert<T = any>(props?: Record<string, unknown>): Promise<T>
    confirm<T = any>(props?: Record<string, unknown>): Promise<T>
    closeAll<T = any>(): Promise<T>
}

declare module 'vue/types/vue' {
    interface Vue {
        $layer: LayerInterface
    }
}
```

Теперь IDE будет подсказывать о методах нашего Layer объекта.

Обратите внимание что расширение файла — `.d.ts`. Потому что в `types` могут храниться только типы, никакого исполняемого кода!

**Папка `models` — проектные форматы данных**

Модели данных нам нужно описывать отдельно в этой папке, потому что не известно где и к каким данным захотим обращаться в приложении. Так же это гарантирует что все важные данные — ответ с бэка, формат данных формы итд —описаны в одной директории и подлежат унификации. Чем быстрее мы опишем стандартные вещи, тем меньше надо будет писать и думать потом.

Пример данных связанных с пагинацией:

```typescript
// file: frontend/models/Pagination.d.ts

/** Данные о пагинации */
export interface Pagination {
    /** Текущая страница */
    page: number

    /** Количество страниц всего */
    pages: number

    /** Количество элементов */
    total: number
}

/** Параметры для пагинации */
export interface PaginationParams {
    /** Текущая страница */
    page: number

    /** Количество элементов на страницу */
    limit: number
}

/** Ответ с сервера с пагинацией */
export interface PaginatedResponse<T> {
    /** Массив элементов */
    items: T[],
    pagination: Pagination
}
```

Здесь тоже не может быть исполняемого кода, поэтому все файлы должны быть `.d.ts`.

#### Внутри файлов `.ts` или `.vue`

Такой формат описания типов вами должен использоваться реже всего. Но он необходим, если надо создать локальный псевдоним, либо объединение типов которое свойственно только в этом месте.

Так в сторах сделано обрезание публичных методов и свойств `PublicModule`, чтобы не было соблазна к ним обращаться и они не мешались в IDE:

```typescript
// Vue:file: frontend/store/index.ts

// Убирает сервисные свойства, чтобы работа делалась через публичные методы интерфейса
type PublicModule<M> = Omit<M, 'modules' | 'state' | 'getters' | 'mutations' | 'namespaced' | 'actions' | 'context'>;

import PageStore from './page';
export let pageStore: PublicModule<PageStore>;
```



## Частые проблемы

### `Binding element 'app' implicitly has an 'any' type.ts(7031)`

Такое будете видеть при описывании подключаемых модулей во фреймворках, где TS не смог узнать тип данных. Надо получить интерфейс из скрипта и указать его явно:

```typescript
// Vue:file: frontend/plugins/page.ts
import { Context } from '@nuxt/types';

export default function({ app }: Context): void {}
```

---

### `Missing return type on function`

Все функции должны явно указывать возвращаемый формат.

---

### `Object is possibly 'undefined'.ts(2532)`

Так случиться, если вы указали свойство объекта необязательным, но пытаетесь с ним работать. 
Можете обернуть всё выражение в `if` и там проверить наличие данных, либо использовать [optional chaining](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Operators/Optional_chaining) → `app.router?.afterEach`