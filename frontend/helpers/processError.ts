import { AxiosError } from 'axios';
import Vue from 'vue';

/**
 *
 * @param error Объект ошибки
 * @param fieldErrors Ссылка на поле компонента для записи ошибок запроса
 */
export default function processError(error: Error & AxiosError, fieldErrors: Record<string, unknown>): void {
    if (error.isAxiosError && error.response) {
        error = error.response.data.error;

        if (fieldErrors) {
            for (const i in fieldErrors) {
                if (Object.prototype.hasOwnProperty.call(fieldErrors, i)) {
                    Vue.delete(fieldErrors, i);
                }
            }

            if (error.request) {
                for (const i in error.request) {
                    if (Object.prototype.hasOwnProperty.call(error.request, i)) {
                        Vue.set(fieldErrors, i, error.request[i]);
                    }
                }
            }
        }
    }

    if (error.message) {
        Vue.prototype.$layer.alert({
            title: 'Ошибка',
            message: error.message
        });
    }
}
