import SettingsApplications from '@material-ui/icons/SettingsApplications';
import EntityInterface, { PropertiesList } from 'entities/EntityInterface';
import _ from 'services/Translations/translate';
import defaultEntityBehavior from 'entities/DefaultEntityBehavior';
import Form from './Form';

const properties:PropertiesList = {
    'name': {
        label: _('Name'),
    },
    'welcomeLocution': {
        label: _('Welcome locution'),
    },
    'holidayLocution': {
        label: _('Holiday locution'),
    },
    'outOfScheduleLocution': {
        label: _('Out of schedule locution'),
    },
    'holidayTargetType': {
        label: _('Holiday target type'),
    },
    'holidayNumberCountry': {
        label: _('Country'),
    },
    'holidayNumberValue': {
        label: _('Number'),
    },
    'holidayExtension': {
        label: _('Extension'),
    },
    'holidayVoiceMailUser': {
        label: _('Voicemail'),
    },
    'outOfScheduleTargetType': {
        label: _('Out of schedule target type'),
    },
    'outOfScheduleNumberCountry': {
        label: _('Country'),
    },
    'outOfScheduleNumberValue': {
        label: _('Number'),
    },
    'outOfScheduleExtension': {
        label: _('Extension'),
    },
    'outOfScheduleVoiceMailUser': {
        label: _('Voicemail'),
    },
    'schedules': {
        label: _('Schedule'),
    },
    'calendars': {
        label: _('Calendar'),
    },
    'whiteLists': {
        label: _('White Lists'),
        helpText: _("Incoming numbers that match this lists will be always ACCEPTED without checking this filter configuration.")
        //@TODO multiselect
    },
    'blackLists': {
        label: _('Black Lists'),
        helpText: _("Incoming numbers that match this lists will be always REJECTED without checking this filter configuration."),
        //@TODO multiselect
    },
};

const extension:EntityInterface = {
    ...defaultEntityBehavior,
    icon: <SettingsApplications />,
    iden: 'ExternalCallFilter',
    title: _('External Call Filter', {count: 2}),
    path: '/external_call_filters',
    properties,
    Form
};

export default extension;