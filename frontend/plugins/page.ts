import { Context } from '@nuxt/types';
import { pageStore } from '~/store';


export default function({ app }: Context): void {
    app.router?.afterEach(function() {
        if (process.client) {
            pageStore.fix();
        }
    });
}
