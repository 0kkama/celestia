import { resolve as _resolve } from 'path';

export const resolve = {
    extensions: ['.js', '.json', '.vue', '.ts'],
    root: _resolve(__dirname),
    alias: {
        '@': _resolve(__dirname),
        '~': _resolve(__dirname)
    }
};
