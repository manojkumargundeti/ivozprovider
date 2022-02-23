import FormatListNumberedIcon from '@mui/icons-material/FormatListNumbered';
import EntityInterface from 'lib/entities/EntityInterface';
import _ from 'lib/services/translations/translate';
import defaultEntityBehavior from 'lib/entities/DefaultEntityBehavior';
import { FriendsPatternProperties } from './FriendsPatternProperties';
import Form from './Form';

const properties: FriendsPatternProperties = {
    'friend': {
        label: _('Friend'),
    },
    'name': {
        label: _('Name'),
    },
    'regExp': {
        label: _('Regular Expression'),
        helpText: _("Avoid PCRE regular expressions here: use [0-9] instead of \\d."),
    },
};

const FriendsPattern: EntityInterface = {
    ...defaultEntityBehavior,
    icon: FormatListNumberedIcon,
    iden: 'FriendsPattern',
    title: _('Friend Pattern', { count: 2 }),
    path: '/friends_patterns',
    properties,
    Form,
};

export default FriendsPattern;