<template>
    <div class="asd">
        <h1 class="my-8 font-bold text-5xl">
            App skeleton
        </h1>
        <div class="mb-8">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
            Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
            Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
            Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
        </div>
        <div class="mb-8">
            <TypescriptLearningTemplate title="Какой-то заголовок установленный пропсом" />
        </div>
        <ul class="mb-8">
            <li>
                <button @click.prevent="$layer.alert()">
                    Alert
                </button>
            </li>
            <li>
                <button @click.prevent="$layer.confirm()">
                    Confirm
                </button>
            </li>
        </ul>
        <div>
            <NuxtLink to="/error-page/">
                Go to error page
            </NuxtLink>
        </div>
    </div>
</template>

<script lang="ts">
import { Vue, Component } from 'nuxt-property-decorator';
import TypescriptLearningTemplate from '~/components/TypescriptLearningTemplate.vue';

@Component({
    // Чтобы работали подсказки пропов в шаблоне, необходимо указывать импорт компонента
    // https://cln.sh/hfJ3RJoStaQN2bGS4Qd8
    components: {
        TypescriptLearningTemplate
    }
})
export default class IndexPage extends Vue {
}
</script>
