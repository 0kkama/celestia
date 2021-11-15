/** Данные о пагинации */
export interface Pagination {
    /** Текущая страница */
    page: number

    /** Количество страниц всего */
    pages: number

    /** Количество элементов */
    total: number
}

/** Параметры для пагинации */
export interface PaginationParams {
    /** Текущая страница */
    page: number

    /** Количество элементов на страницу */
    limit: number
}

/** Ответ с сервера с пагинацией */
export interface PaginatedResponse<T> {
    /** Массив элементов */
    items: T[],
    pagination: Pagination
}
