export interface BaseFile {
    url: string

    /** Имя сохранённого файла */
    name: string

    /** Оригинальное имя загруженного файла */
    originalName: string

    extension: string
    size: string
}

export interface ImageFile extends BaseFile {}
