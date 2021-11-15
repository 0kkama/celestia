let counter = 0;

/**
 * @param prefix словестное уточнение идентификатора
 */
export const generateUuid = (prefix: string): string => prefix + ++counter;

export default (): void => {
    counter = 0;
};
