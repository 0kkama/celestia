<template>
    <div class="layer">
        <div class="layer-container">
            <div v-if="title" v-html="title"></div>
            <div v-if="description" v-html="description"></div>
            <div v-if="message" v-html="message"></div>
            <div>
                <button ref="acceptActionElement" type="button" @click.prevent="$emit('close', true)">
                    <span>{{ acceptButtonCaption }}</span>
                </button>
                <button type="button" @click.prevent="$emit('close')">
                    <span>{{ declineButtonCaption }}</span>
                </button>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import { Vue, Component, Ref, Prop } from 'nuxt-property-decorator';

@Component({
    mounted(this: ConfirmLayer) {
        this.acceptActionElement.focus();
    }
})
export default class ConfirmLayer extends Vue {
    @Prop({ type: String, default: 'Подтверждение' })
    readonly title!: string;

    @Prop({ type: String })
    readonly description?: string;

    @Prop({ type: String })
    readonly message?: string;

    @Prop({ type: String, default: 'Да' })
    readonly acceptButtonCaption!: string;

    @Prop({ type: String, default: 'Нет' })
    readonly declineButtonCaption!: string;

    @Ref()
    readonly acceptActionElement!: HTMLButtonElement;
}
</script>
