import formatNumber, { NumberFormatOptions } from './formatNumber';

const defaultPriceFormatter = new Intl.NumberFormat('ru-RU', { style: 'currency', currency: 'RUB', minimumFractionDigits: 0 });

/**
 * Форматирует число в красивую цену согласно стандартам
 * {@link https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Intl/NumberFormat Документация}
 *
 * @param number стоимость
 * @param options параметры форматирования
 */
export default function formatPrice(number: number, options?: NumberFormatOptions): string {
    if (options) {
        return formatNumber(number, { style: 'currency', minimumFractionDigits: number % 1 ? 2 : 0, ...options });
    }

    return defaultPriceFormatter.format(number);
}
