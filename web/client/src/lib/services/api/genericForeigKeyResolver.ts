import ApiClient from './ApiClient';

export default async function genericForeignKeyResolver(
    data: any,
    fkFld: string,
    entityEndpoint: string,
    toStr: (row: { [key: string]: any }) => string,
    addLink = true
) {
    if (typeof data !== 'object') {
        return data;
    }

    if (!Array.isArray(data) && (typeof data[fkFld] !== 'object' || data[fkFld] === null)) {
        return data;
    }

    if (!Array.isArray(data)) {
        // Just flat view's detailed model
        data[fkFld] = toStr(data[fkFld]);

        return data;
    }

    const ids: Array<number> = [];
    for (const idx in data) {
        if (data[idx][fkFld]) {

            const val = data[idx][fkFld];
            const iterableValues: Array<any> = Array.isArray(val)
                ? val
                : [val];

            for (const value of iterableValues) {
                if (ids.includes(value)) {
                    continue;
                }

                ids.push(
                    value
                );
            }
        }
    }

    if (ids.length) {
        await ApiClient.get(
            entityEndpoint,
            {
                id: ids,
                _pagination: false
            },
            async (response: any, headers: any) => {

                const entityReducer = async (accumulator: any, value: any) => {

                    accumulator[value.id] = toStr(value);

                    return accumulator;
                };

                let entities: any = {};
                for (const idx in response) {
                    entities = await entityReducer(entities, response[idx]);
                }

                for (const idx in data) {
                    if (data[idx][fkFld]) {

                        const fk = data[idx][fkFld];
                        if (Array.isArray(fk)) {
                            for (const key in fk) {
                                fk[key] = entities[fk[key]];
                            }

                            data[idx][fkFld] = fk.join(', ');
                            continue;
                        }

                        data[idx][`${fkFld}Id`] = data[idx][fkFld];
                        if (addLink) {
                            data[idx][`${fkFld}Link`] = `${entityEndpoint}/${fk}/update`;
                        }
                        data[idx][fkFld] = entities[fk];
                    }
                }
            }
        );
    }

    return data;
}

export const remapFk = (row: any, from: string, to: string) => {

    row[to] = row[from];
    row[`${to}Id`] = row[`${from}Id`];
    row[`${to}Link`] = row[`${from}Link`];
}