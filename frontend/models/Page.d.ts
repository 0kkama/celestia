import { WidgetBlocksList } from './Widgets';

export interface ContentData {
    id: number
    text: string
    blocks?: WidgetBlocksList
}

export interface PageData {
    id: number
    slug: string
    url: string
    title: string
    meta?: {
        title: string
        description: string
        keywords: string
    }
    content?: ContentData
}
