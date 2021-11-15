import { Context } from '@nuxt/types';
import PageService from '~/services/Page';
import { pageStore } from '~/store';


export default function({ route }: Context): Promise<void> {
    const pathOrName = route.name === 'all' ? route.path : route.name as string;

    return PageService.fetchData(pathOrName)
        .then(page => pageStore.update(page))
        .catch(() => pageStore.reset())
        .finally(() => {
            if (process.server) {
                pageStore.fix();
            }
        });
}
