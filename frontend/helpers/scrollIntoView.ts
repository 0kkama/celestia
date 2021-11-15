/**
 * Метод для скрола
 * @param {HTMLElement} element элемент для показа
 * @param {Object} [options] сдвиги
 * @param {number} [options.y] сдвиг по вертикали
 * @param {'smooth' | 'auto'} [options.behavior] сдвиг по вертикали
 * @param {Window | HTMLElement} [overflowElement] контейнер для скрола
 */
export default function scrollIntoViewElement(element: Element, options: any, overflowElement: Window | Element = window): Element {
    const { y = 0, behavior = 'smooth' } = options || {};
    const top = overflowElement instanceof Window ? element.getBoundingClientRect().top : element.getBoundingClientRect().top - overflowElement.getBoundingClientRect().top;

    if (typeof element.scrollTo === 'function') {
        window.scrollTo({
            top: top + (overflowElement instanceof Window ? overflowElement.pageYOffset : overflowElement.scrollTop) + y,
            behavior
        });

    } else if (overflowElement instanceof Window) {
        (document.scrollingElement || document.documentElement).scrollTop = top + overflowElement.pageYOffset + y;

    } else {
        overflowElement.scrollTop = top + overflowElement.scrollTop + y;
    }

    return element;
}
