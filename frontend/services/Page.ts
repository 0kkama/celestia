import api, { RequestConfig } from '~/helpers/api';
import { PageData, ContentData } from '~/models/Page';


export default class PageService {
    /**
     * Получить данные страницы
     * @param pathOrName Путь или имя страницы
     * @param config Настройки запроса
     */
    static fetchData(pathOrName: string, config?: RequestConfig): Promise<PageData> {
        // Если это путь
        if (pathOrName.startsWith('/')) {
            return api.get('/api/pages', { ...config, params: { ...config?.params, path: pathOrName } });
        }

        return api.get('/api/pages/' + pathOrName, config);
    }

    /**
     * Получить контент страницы/блока
     * @param id Идентификатор контента
     * @param config Настройки запроса
     */
    static fetchContent(id: number, config?: RequestConfig): Promise<ContentData> {
        return api.get('/api/contents/' + id, config);
    }
}
