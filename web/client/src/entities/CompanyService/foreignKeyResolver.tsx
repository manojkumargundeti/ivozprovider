import genericForeignKeyResolver from 'lib/services/api/genericForeigKeyResolver';
import entities from '../index';
import { CompanyServicePropertiesList } from './CompanyServiceProperties';
import { foreignKeyResolverType } from 'lib/entities/EntityInterface';

const foreignKeyResolver: foreignKeyResolverType = async function (
    { data, cancelToken }
): Promise<CompanyServicePropertiesList> {
    const promises = [];
    const { Service } = entities;

    promises.push(
        genericForeignKeyResolver({
            data,
            fkFld: 'service',
            entity: Service,
            addLink: false,
            cancelToken,
        })
    );

    await Promise.all(promises);

    return data;
}

export default foreignKeyResolver;