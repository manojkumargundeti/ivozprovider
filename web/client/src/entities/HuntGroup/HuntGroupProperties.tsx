import { PropertySpec } from "lib/services/api/ParsedApiSpecInterface";
import { EntityValue, EntityValues } from "lib/services/entity/EntityService";

type HuntGroupPropertyList<T> = {
    'name'?: T,
    'description'?: T,
    'strategy'?: T,
    'preventMissedCalls'?: T,
    'allowCallForwards'?: T,
    'ringAllTimeout'?: T,
    'noAnswerTargetType'?: T,
    'noAnswerLocution'?: T,
    'noAnswerNumberCountry'?: T,
    'noAnswerNumberValue'?: T,
    'noAnswerExtension'?: T,
    'noAnswerVoiceMailUser'?: T,
};

export type HuntGroupProperties = HuntGroupPropertyList<Partial<PropertySpec>>;

export type HuntGroupPropertiesList = Array<HuntGroupPropertyList<EntityValue | EntityValues>>;