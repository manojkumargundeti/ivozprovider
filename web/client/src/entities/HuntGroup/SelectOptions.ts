import defaultEntityBehavior from '../DefaultEntityBehavior';

const HuntGroupSelectOptions = (callback: Function) => {

    defaultEntityBehavior.fetchFks(
        '/hunt_groups',
        ['id', 'name'],
        (data:any) => {
            const options:any = {};
            for (const item of data) {
                options[item.id] = item.name;
            }

            callback(options);
        }
    );
}

export default HuntGroupSelectOptions;