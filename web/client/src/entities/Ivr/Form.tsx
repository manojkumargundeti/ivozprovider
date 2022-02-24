import useFkChoices from 'lib/entities/data/useFkChoices';
import defaultEntityBehavior, { EntityFormProps, FieldsetGroups } from 'lib/entities/DefaultEntityBehavior';
import _ from 'lib/services/translations/translate';
import { foreignKeyGetter } from './foreignKeyGetter';

const Form = (props: EntityFormProps): JSX.Element => {

    const { entityService } = props;
    const DefaultEntityForm = defaultEntityBehavior.Form;
    const fkChoices = useFkChoices(foreignKeyGetter, entityService);

    const groups: Array<FieldsetGroups> = [
        {
            legend: _('Basic Configuration'),
            fields: [
                'name',
                'timeout',
                'maxDigits',
                'welcomeLocution',
                'successLocution',
            ]
        },
        {
            legend: _('Extension dialing'),
            fields: [
                'allowExtensions',
                'excludedExtensionIds',
            ]
        },
        {
            legend: _('No input configuration'),
            fields: [
                'noInputLocution',
                'noInputRouteType',
                'noInputNumberCountry',
                'noInputNumberValue',
                'noInputExtension',
                'noInputVoiceMailUser',
            ]
        },
        {
            legend: _('Error configuration'),
            fields: [
                'errorLocution',
                'errorRouteType',
                'errorNumberCountry',
                'errorNumberValue',
                'errorExtension',
                'errorVoiceMailUser',
            ]
        },
    ];

    return (<DefaultEntityForm {...props} fkChoices={fkChoices} groups={groups} />);
}

export default Form;