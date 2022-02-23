import { autoForeignKeyResolver } from 'lib/entities/DefaultEntityBehavior';
import { foreignKeyResolverType } from 'lib/entities/EntityInterface';
import genericForeignKeyResolver from 'lib/services/api/genericForeigKeyResolver';
import entities from '../index';
import { UsersCdrRow, UsersCdrRows } from './UsersCdrProperties';

function ownerAndPartyResolver(row: UsersCdrRow, addLinks = true): UsersCdrRow {

    // Owner
    if (row.userId) {
        row.owner = row.user;
        if (addLinks) {
            row.ownerId = row.userId;
            row.ownerLink = row.userLink;
        }
    } else if (row.friendId) {
        row.owner = row.friendId;
        if (addLinks) {
            row.ownerId = row.friendId;
            row.ownerLink = row.friendLink;
        }
    } else if (row.retailAccountId) {
        row.owner = row.retailAccount;
        row.ownerId = row.retailAccountId;
        row.ownerLink = row.retailAccountLink;
    } else if (row.residentialDeviceId) {
        row.owner = row.residentialDevice;
        if (addLinks) {
            row.ownerId = row.residentialDeviceId;
            row.ownerLink = row.residentialDeviceLink;
        }
    } else if (row.direction === 'outbound') {
        row.owner = row.caller;
    } else {
        row.owner = row.callee;
    }

    // Party
    if (row.direction === 'outbound') {
        row.party = row.callee;
    } else {
        row.party = row.caller;
    }

    return row;
}

export const foreignKeyResolver: foreignKeyResolverType = async function(
    { data, allowLinks = true, cancelToken, entityService }
): Promise<UsersCdrRows> {

    const { User, Extension } = entities;

    const promises = autoForeignKeyResolver({
        data,
        cancelToken,
        entityService,
        entities,
        skip: [
            'user',
        ]
    });

    promises.push(
        // User & User.extension
        genericForeignKeyResolver({
            data,
            fkFld: 'user',
            entity: {
                ...User,
                toStr: (row: any) => {
                    let response = `${row.name} ${row.lastname}`;
                    if (row.extensionId) {
                        response += ` (${row.extension})`
                    }

                    return response;
                }
            },
            addLink: allowLinks,
            cancelToken,
            dataPreprocesor: async (rows: any) => {
                try {
                    await genericForeignKeyResolver({
                        data: Array.isArray(rows) ? rows : [rows],
                        fkFld: 'extension',
                        entity: Extension,
                        addLink: false,
                        cancelToken,
                    });
                } catch { }

                return rows;
            }
        })
    );

    await Promise.all(promises);

    const iterable = Array.isArray(data)
        ? data
        : [data];

    for (const idx in iterable) {
        iterable[idx] = ownerAndPartyResolver(iterable[idx]);
        iterable[idx].duration = Math.round(iterable[idx].duration as number);
    }

    return data;
}

export default foreignKeyResolver;