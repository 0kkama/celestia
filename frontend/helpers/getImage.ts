/**
 * @param imageUrl ссылка на оригинальную картинку
 * @param options настройки
 * @returns Ссылка на оптимизированную картинку
 */
export default function getImage(imageUrl: string, options: string): string {
    imageUrl = imageUrl.match(/^https?:\/\//) ? imageUrl : ('local://' + imageUrl);

    return [
        '/_image',
        'i',
        options,
        Buffer.from(imageUrl)
            .toString('base64')
            .replace(/\+/g, '-')
            .replace(/\//g, '_')
            .replace(/=+$/, '')
    ].join('/');
}
