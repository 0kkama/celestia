import { ImageFile } from './Files';

interface BaseWidget {
    id: number
    type: string
    title?: string
    size?: number
    blocks?: BaseWidget[]
}

export interface TextWidget extends BaseWidget {
    type: 'text',
    /** HTML строка */
    data: string
}

export interface ImageWidget extends BaseWidget {
    type: 'image',
    image: string | {
        file: ImageFile
    }
}

export type WidgetBlocksList = (TextWidget | BaseWidget)[];
