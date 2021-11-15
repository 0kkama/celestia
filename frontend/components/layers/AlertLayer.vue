<template>
    <div class="layer">
        <div class="layer-container">
            <div v-if="title" v-html="title"></div>
            <div v-if="description" v-html="description"></div>
            <div v-if="message" v-html="message"></div>
            <div>
                <button ref="closeActionElement" type="button" class="btn" @click.prevent="$emit('close')">
                    <span>{{ buttonCaption }}</span>
                </button>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import { Vue, Component, Ref, Prop } from 'nuxt-property-decorator';

@Component({
    mounted(this: AlertLayer) {
        this.closeActionElement.focus();
    }
})
export default class AlertLayer extends Vue {
    @Prop(String)
    title: string|undefined;

    @Prop(String)
    description?: string;

    @Prop(String)
    message?: string;

    @Prop({ type: String, default: 'Понимаю' })
    buttonCaption!: string;

    @Ref()
    readonly closeActionElement!: HTMLButtonElement;
}
</script>
