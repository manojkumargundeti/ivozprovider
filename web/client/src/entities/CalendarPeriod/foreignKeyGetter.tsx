import { CalendarPeriodPropertyList } from './CalendarPeriodProperties';
import { ForeignKeyGetterType } from 'lib/entities/EntityInterface';
import ScheduleSelectOptions from 'entities/Schedule/SelectOptions';
import { autoSelectOptions } from 'lib/entities/DefaultEntityBehavior';
import entities from '../index';

export const foreignKeyGetter: ForeignKeyGetterType = async ({cancelToken, entityService}): Promise<any> => {

    const response: CalendarPeriodPropertyList<unknown> = {};

    const promises = autoSelectOptions({
        entities,
        entityService,
        cancelToken,
        response,
        skip: [
            'scheduleIds',
        ]
    });

    promises[promises.length] = ScheduleSelectOptions({
        callback: (options: any) => {
            response.scheduleIds = options;
        },
        cancelToken
    });

    await Promise.all(promises);

    return response;
};