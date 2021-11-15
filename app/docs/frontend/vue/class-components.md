# Как писать компоненты используя классы

Из-за того что нативно во Vue2 нет поддержки TS, приходиться использовать обходные решения. В нашем случае это декораторы — [nuxt-property-decorator](https://github.com/nuxt-community/nuxt-property-decorator).

[[_TOC_]]

**Ссылки:**

- [nuxt-property-decorator](https://github.com/nuxt-community/nuxt-property-decorator)
- [vue-property-decorator](https://github.com/kaorun343/vue-property-decorator)
- [vue-class-component](https://github.com/vuejs/vue-class-component)
- [Про декораторы](https://www.typescriptlang.org/docs/handbook/decorators.html)



## Классы или как создать компонент

Так как теперь всё на классах, сначала нам надо импортировать необходимые декораты для него:

```typescript
import { Vue, Component } from 'nuxt-property-decorator';
```

Если этого не сделать, то IDE начнём рандомно получать интерфейсы из разных пакетов. Чтобы этого не было, надо хотя бы написать `import {} from 'nuxt-property-decorator'`. После этого все предлагаемые вещи будут импортироваться корректно из одного пакета. Не забывайте про чистоту кода :-)

Раньше мы экспортировали объект со свойствами. Теперь там должен быть класс + декоратор. Важно чтобы имя этого класса тоже было нормальным, в нашем случае это будет `TestComponent`, оно нам пригодится позже:

```typescript
@Component
export default class TestComponent extends Vue {}
```

По сути, это всё. Теперь можно использовать типизацию в нашем компоненте для свойств, пропов и прочего.



## Настройки и хуки

components

hooks

settings



## Данные, методы и другие свойства

### Как объявить `data()` в классах

У нас больше нет свойства `data` где содержится вся информация компонента. За это отвечают обычные свойства у класса:

```typescript
@Component
export default class TestComponent extends Vue {
	testingData = null;
}
```

Теперь мы можем в шаблоне, хуках, методах ... итд обратиться к полю `testingData`. Не используйте хук `data` в классовых компонентах!

Обратите внимание что присвоено значение `null`. Важно так указывать, если изначально там не планируется данных! Иначе это поле не будет инициализировано.

Но из-за того что теперь свойства могут быть расскиданы по всему классу, становиться сложнее понять какими данными управляет компонент. Поэтому необходимо описывать все свойства в интерфейсе, который должен быть реализован классом:

```typescript
// Интерфейс описывает все данные компонента, которые обычно определяем в `data()`
interface TestComponentData {
    testingData: string|null
}

@Component
export default class TestComponent extends Vue implements TestComponentData {
	testingData: TestComponentData['testingData'] = null;
}
```

Таким образом мы гарантируем что все свойства объекта будут с корректными типами, что можно будет обратиться к типу в любом месте компонента, и в одном месте видно к каким данным есть доступ.

- [Про `data()` в классах](https://class-component.vuejs.org/guide/class-component.html#data)



### Как создать `computed()`

Все вычесляемые свойства теперь это геттеры.

```typescript
@Component
export default class TestComponent extends Vue implements TestComponentData {
    get testingDataComputed(): string {
        return 'this.testingData = ' + this.testingData;
    }
}
```

Ну и соотвественно, если нам нужен `get/set` computed, то надо добавить копию этого свойства, только ключевое слово будет `set`.

- [Про геттеры](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Functions/get)
- [Про сеттеры](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Functions/set)
- [Тоже про get и set](https://javascript.info/property-accessors#:~:text=Accessor%20properties%20are%20represented%20by,code%20executed%20on%20getting%20obj.)
- [Про `computed` в классах](https://class-component.vuejs.org/guide/class-component.html#computed-properties)



### Как писать `methods`

Ну тут думаю всем ясно. Просто как в обычном классе, ничего такого. Главное не забываем про возвращаемый тип:

```typescript
@Component
export default class TestComponent extends Vue implements TestComponentData {
    setTestingData(): void {
        this.testingData = 'Динамические данные';
    }
}
```

- [Про методы](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Functions/Method_definitions)
- [Про `methods` в классах](https://class-component.vuejs.org/guide/class-component.html#methods)



### Как описать `props`

Вот тут нам пригодится ещё один декоратор — `@Prop`.

```typescript
@Component
export default class TestComponent extends Vue implements TestComponentData {
    @Prop({ type: String, default: null })
    readonly customPropForData!: string|null;
}
```

`@Prop` может принимать в себя объект настроек, один тип или массив типов. Так же как и раньше, только теперь в декораторе. Я предпочитаю запись в формате объекта, потому что она наиболее детальная.

Так как пропы не содержат в себе данных по умолчанию, свойство класса объявляется без значения, только с набором типов. Из-за этого надо TS сообщить что значение будет существовать в рантайме, поэтому ставим восклицательный знак перед двоеточием. Так мы говорим что мы точно собираемся использовать это свойство при инициализации и даже обязуемся записать туда данные.

И ещё — все пропы у нас доступны только для чтения. Поэтому так их и помечаем `readonly`.

Дефолтное значение устанавливается в настройках декоратора и никак иначе! Не пытайтесь присвоить значение свойству напрямую.

- [Про декоратор `@Prop`](https://github.com/kaorun343/vue-property-decorator#Prop)
- [Про воскликацетьный знак — строгое объявление свойства](https://www.typescriptlang.org/docs/handbook/release-notes/typescript-2-7.html#strict-class-initialization)



### Как использовать `model`

Во Vue3 теперь нет такого свойства, всё работает на механизме `v-bind.sync`. Поэтому мы можем перенять эту практику уже сейчас и использовать декоратор `@PropSync`.

```typescript
@Component
export default class TestComponent extends Vue implements TestComponentData {
    @PropSync('propName', { type: String, default: null })
    readonly customPropForData!: string|null;
}
```

Одно отличие от `@Prop` в том что первым параметром мы передаём имя свойства. А само свойство играет роль `computed` с установленными `get/set`. Одно отличие, снаружи компонента надо будет писать не `v-model`, а `v-bind:propName.sync`.

Про декораторы @Model, @VModel и @ModelSync почитаете сами. Уделите внимание `@ModelSync`, такой паттерн может пригодится когда-нибудь.

- [`.sync` модификатор](https://vuejs.org/v2/guide/components-custom-events.html#sync-Modifier)
- [Про `@PropSync`](https://github.com/kaorun343/vue-property-decorator#-propsyncpropname-string-options-propoptions--constructor--constructor---decorator)
- [Про `@Model`](https://github.com/kaorun343/vue-property-decorator#-modelevent-string-options-propoptions--constructor--constructor---decorator)
- [Про `@ModelSync`](https://github.com/kaorun343/vue-property-decorator#-modelsyncpropname-string-event-string-options-propoptions--constructor--constructor---decorator)
- [Про `@VModel`](https://github.com/kaorun343/vue-property-decorator#-vmodelpropsargs-propoptions-decorator)



### Как использовать `watch`

Вместо свойста, у нас теперь есть декоратор `@Watch`. В принципе, ничем не отличается от обычной записи, только настройки теперь вынесены в параметры декоратора:

```typescript
@Component
export default class TestComponent extends Vue implements TestComponentData {
    @Watch('customPropForData', { immediate: true })
    onCustomPropChanged(value, oldValue): void {}
}
```

- [Про `@Watch`](https://github.com/kaorun343/vue-property-decorator#-watchpath-string-options-watchoptions---decorator)



### Как обратиться к DOM Element'у в шаблоне `ref`

Для свойства где храниться объект DOM, необходимо использовать декоратор `@Ref`. Он позволит корректно установить тип элемента и TS не будет ругаться на вас.

```typescript
@Component
export default class TestComponent extends Vue implements TestComponentData {
    @Ref()
    readonly acceptActionElement!: HTMLButtonElement;
}
```

Ещё вы межете передать первым параметром имя которое будете использовать в шаблоне — `@Ref('coolButton')`. Но лучше так не делайте, потому что это только путает, а не помогает.

И теперь в методах вам нужно будет обращаться к этому свойству напрямую, а не `this.$refs`.

- [Про `@Ref`](https://github.com/kaorun343/vue-property-decorator#-refrefkey-string-decorator)





