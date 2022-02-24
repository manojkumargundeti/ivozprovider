import defaultEntityBehavior, { EntityFormProps, FieldsetGroups } from 'lib/entities/DefaultEntityBehavior';
import useFkChoices from './foreignKeyGetter';

const Form = (props: EntityFormProps): JSX.Element => {

    const { entityService } = props;

    const currentServiceId: number | undefined = props?.row?.service?.id;
    const DefaultEntityForm = defaultEntityBehavior.Form;
    const fkChoices = useFkChoices(entityService, currentServiceId);

    const groups: Array<FieldsetGroups> = [
        {
            legend: '',
            fields: [
                'service',
                'code',
            ]
        }
    ];

    const readOnlyProperties = {
        service: props.edit ? true : false,
    };

    return (<DefaultEntityForm {...props} fkChoices={fkChoices} groups={groups} readOnlyProperties={readOnlyProperties} />);
}

export default Form;