<template>
    <div class="custom-styled">
        <div class="aspect-w-16 aspect-h-3 md:aspect-w-4 mb-10">
            <iframe
                width="560"
                height="315"
                src="https://www.youtube.com/embed/n_FOM_xlqdU"
                title="YouTube video player"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen
            ></iframe>
        </div>

        <div class="mb-6">
            prop / title: {{ title }}
        </div>

        <div class="mb-6">
            data / someDataContent: {{ someDataContent }}
            <br>
            присваивается значение из `title`
        </div>

        <div class="mb-6">
            Вычесляемое свойство testingDataComputed: {{ testingDataComputed }}
        </div>

        <div class="mb-6">
            testingData: {{ testingData }}
            <button v-if="!testingData" @click="setTestingData">
                установить данные
            </button>
        </div>
    </div>
</template>

<script lang="ts">
/**
 * @todo Вынести создание компонента в CLI
 *
 * Это болванка компонента.
 * Следует удалить этот файл, когда уже будут созданы какие-нибудь компоненты где можно будет посмотреть другим спецам как работать с `nuxt-property-decorator`.
 */
import { Vue, Component, Prop } from 'nuxt-property-decorator';
import { PageData } from '~/models/Page';
import PageService from '~/services/Page';
import { pageStore } from '~/store';

// Интерфейс описывает все данные компонента, которые обычно определяем в `data()`
interface TestComponentData {
    someDataContent: string|null
    testingData: string|null
    page: PageData|null
}

// Все хуки и настройки компонента должны быть переданы параметром декоратора
@Component({
    fetchOnServer: false,
    // Чтобы в хуках можно было обращаться к свойствам и методам класса, необходимо установить тип контекста как класс компонента `this: TestComponent`
    // fetch должен возвращать тип `Promise<void>` если используете `async/await`
    // fetch должен возвращать тип `Promise<any>` если используете `return Promise.all`
    async fetch(this: TestComponent): Promise<void> {
        const page = await PageService.fetchData('index');
        this.page = page;

        // const pageData = await Promise.resolve('some data');
        // this.testingData = pageData;
    },

    created(this: TestComponent) {
        console.log('created hook :: testingProp: ', this.testingProp, '\n\n');
    },
    mounted(this: TestComponent) {
        console.log('mounted hook :: title: ', this.title, '\n\n');
        this.printLogs();
    }
})
// Не забываем `implements ComponentData` чтобы TS ругнулся если вы забыли определить какое-то поле в классе
export default class TestComponent extends Vue implements TestComponentData {
    /** Человеческое описание свойства. Документируйте за что отвечает проп. Комментарий надо писать именно в `\/** *\/` чтобы корректно ТС подсказывал */
    // Всегда в декораторе нужно указывать тип данных, иначе Vue не будет знать о том что там внутри ожидается
    @Prop({ type: String, required: true })
    readonly title!: string;

    // Так же у необязательный свойств нужно указывать дефолтное значение `null`, если вы хотите присвоить это значение сразу в свойство `data`. Смотрите дальше `someDataContent`
    @Prop({ type: String, default: null })
    readonly customPropForData!: string|null;

    @Prop({ type: String })
    readonly customProp!: string;

    // Настройки пропа педавать необходимо в параметре к декоратору.
    @Prop({ type: String, default: 'Дефолтное значение' })
    readonly testingProp!: string;

    // Чтобы обратиться к пропу и присвоить его значение в `data()`
    // У необязательного пропа нужно установить дефолтное значение, иначе свойство не будет создано и ошибка рендера появится
    // Если в дефолтном значении не должно быть данных, то указывайте `null`
    someDataContent: TestComponentData['someDataContent'] = this.customPropForData;
    // Иначе будет ошибка
    // someDataContent: TestComponentData['someDataContent'] = this.customProp;

    // Допустим вам надо создать поле в дате, чтобы заполнить его при фетче
    // Используйте `null` значение, чтобы переменная была инициализирована
    // https://class-component.vuejs.org/guide/class-component.html#data
    testingData: TestComponentData['testingData'] = null;

    // Все методы должны указывать возвращаемый тип данных
    setTestingData(): void {
        this.testingData = 'Динамические данные';
    }

    get testingDataComputed(): string {
        return 'this.testingData = ' + this.testingData;
    }


    page: TestComponentData['page'] = null;

    printLogs(): void {
        console.log('page / from data :: page: ', this.page || 'Запрос ещё не выполнился', '\n\n');
        console.log('page / from store :: pageStore.data: ', pageStore.data, '\n\n');
    }
}
</script>

<style lang="postcss" scoped>
/*
    В локальных стилях нельзя использовать некоторые директивы:
    - layer
    - responsive
    - variants

    Избегайте написания своего CSS всеми путями!
*/
.custom-styled {
    @apply text-gray-500;
}

@screen md {
    .custom-styled {
        @apply text-red-500;
    }
}
</style>
