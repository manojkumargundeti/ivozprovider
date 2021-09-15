import SettingsApplications from '@mui/icons-material/SettingsApplications';
import EntityInterface, { PropertiesList } from 'lib/entities/EntityInterface';
import _ from 'lib/services/translations/translate';
import defaultEntityBehavior from 'lib/entities/DefaultEntityBehavior';
import { getI18n } from 'react-i18next';

const properties: PropertiesList = {};

const country: EntityInterface = {
    ...defaultEntityBehavior,
    icon: <SettingsApplications />,
    iden: 'Country',
    title: _('Country', { count: 2 }),
    path: '/countries',
    toStr: (row: any) => {
        const language = getI18n().language.substring(0, 2);
        return row.name[language];
    },
    properties,
};

export default country;