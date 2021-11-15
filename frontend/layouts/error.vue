<template>
    <div class="container my-8">
        <div class="not-found">
            <template v-if="error.statusCode === 500">
                <div class="not-found-subtitle">
                    {{ errorMessage }}
                </div>

                <div class="not-found-buttons">
                    <button class="btn" @click.prevent="reload">
                        <span>Перезагрузить страницу</span>
                    </button>
                </div>
            </template>
            <template v-else>
                <div class="not-found-subtitle">
                    {{ error.statusCode === 500 ? errorMessage : 'Страница не найдена' }}
                </div>

                <div class="not-found-text">
                    <br>
                    К&nbsp;сожалению, страница, которую&nbsp;Вы запросили, не&nbsp;была найдена (ошибка 404).
                    Вы&nbsp;можете перейти
                    <NuxtLink :to="{name: 'index'}">
                        на&nbsp;главную страницу
                    </NuxtLink>
                </div>
            </template>
        </div>
    </div>
</template>

<script lang="ts">
import { NuxtError } from '@nuxt/types';
import { Vue, Component, Prop } from 'nuxt-property-decorator';

@Component
export default class ErrorPage extends Vue {
    @Prop()
    readonly error!: NuxtError;

    get errorMessage(): string {
        const defaultMessage = 'Произошла ошибка';

        if (this.$store.app.context.isDev) {
            return this.error.message || defaultMessage;
        }

        return defaultMessage;
    }

    reload(): void {
        location.reload();
    }
}
</script>
