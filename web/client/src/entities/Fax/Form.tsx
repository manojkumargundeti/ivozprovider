import defaultEntityBehavior, { FieldsetGroups } from 'lib/entities/DefaultEntityBehavior';
import { useEffect, useState } from 'react';
import DdiSelectOptions from 'entities/Ddi/SelectOptions';
import _ from 'lib/services/translations/translate';

const Form = (props: any) => {

    const DefaultEntityForm = defaultEntityBehavior.Form;

    const [fkChoices, setFkChoices] = useState<any>({});
    const [mounted, setMounted] = useState<boolean>(true);
    const [loadingFks, setLoadingFks] = useState<boolean>(true);

    useEffect(
        () => {
            if (mounted && loadingFks) {

                DdiSelectOptions((options: any) => {
                    mounted && setFkChoices((fkChoices: any) => {
                        return {
                            ...fkChoices,
                            outgoingDdi: options,
                        }
                    });
                });

                setLoadingFks(false);
            }

            return function umount() {
                setMounted(false);
            };
        },
        [loadingFks, fkChoices]
    );

    const groups: Array<FieldsetGroups> = [
        {
            legend: _('Outbound configuration'),
            fields: [
                'name',
                'outgoingDdi',
            ]
        },
        {
            legend: _('Inbound configuration'),
            fields: [
                'sendByEmail',
                'email',
            ]
        },
    ];

    return (<DefaultEntityForm fkChoices={fkChoices} groups={groups} {...props} />);
}

export default Form;