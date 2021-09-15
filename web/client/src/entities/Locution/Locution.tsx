import SettingsApplications from '@mui/icons-material/SettingsApplications';
import EntityInterface, { PropertiesList } from 'lib/entities/EntityInterface';
import _ from 'lib/services/translations/translate';
import defaultEntityBehavior from 'lib/entities/DefaultEntityBehavior';
import Form from './Form';

const properties: PropertiesList = {
    'name': {
        label: _('Name'),
    },
    //@TODO POSPONED originalFile
    'status': {
        label: _('Status'),
        enum: {
            'pending': _('pending'),
            'encoding': _('encoding'),
            'ready': _('ready'),
            'error': _('error'),
        }
    }
};

const locution: EntityInterface = {
    ...defaultEntityBehavior,
    icon: <SettingsApplications />,
    iden: 'Locution',
    title: _('Locution', { count: 2 }),
    path: '/locutions',
    properties,
    Form
};

export default locution;