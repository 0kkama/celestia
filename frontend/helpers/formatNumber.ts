const defaultNumberFormatter = new Intl.NumberFormat('ru-RU', { style: 'decimal', currency: 'RUB', minimumFractionDigits: 0 });

export type NumberFormatOptions = Intl.NumberFormatOptions & {locale?: string};

/**
 * Приводит число согласно стандартам
 * {@link https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Intl/NumberFormat Документация}
 *
 * @param number число
 * @param options параметры форматирования
 */
export default function formatNumber(number: number, options?: NumberFormatOptions): string {
    if (options) {
        const { locale = 'ru-RU', ...restOptions } = options;

        return new Intl.NumberFormat(locale, {
            style: 'decimal',
            currency: 'RUB',
            minimumFractionDigits: 0,
            ...restOptions
        }).format(number);
    }

    return defaultNumberFormatter.format(number);
}
