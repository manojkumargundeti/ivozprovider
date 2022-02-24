import defaultEntityBehavior, { FieldsetGroups } from 'lib/entities/DefaultEntityBehavior';
import { ViewProps } from 'lib/entities/EntityInterface';
import _ from 'lib/services/translations/translate';

const View = (props: ViewProps): JSX.Element | null => {

    const groups: Array<FieldsetGroups | false> = [
        {
            legend: _('Call Details'),
            fields: [
                'startTime',
                'duration',
                'owner',
                'direction',
                'party',
            ]
        }
    ];

    return (<defaultEntityBehavior.View {...props} groups={groups} />);
}

export default View;