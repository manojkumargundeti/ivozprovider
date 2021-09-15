import defaultEntityBehavior from 'lib/entities/DefaultEntityBehavior';
import { useEffect, useState } from 'react';
import InvoiceSelectOptions from 'entities/Invoice/SelectOptions';
import DdiProviderSelectOptions from 'entities/DdiProvider/SelectOptions';

const Form = (props: any) => {

    const DefaultEntityForm = defaultEntityBehavior.Form;

    const [fkChoices, setFkChoices] = useState<any>({});
    const [mounted, setMounted] = useState<boolean>(true);
    const [loadingFks, setLoadingFks] = useState<boolean>(true);

    useEffect(
        () => {

            if (mounted && loadingFks) {

                InvoiceSelectOptions((options: any) => {
                    mounted && setFkChoices((fkChoices: any) => {
                        return {
                            ...fkChoices,
                            invoice: options
                        }
                    });
                });

                DdiProviderSelectOptions((options: any) => {
                    mounted && setFkChoices((fkChoices: any) => {
                        return {
                            ...fkChoices,
                            ddiProvider: options
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

    return (<DefaultEntityForm fkChoices={fkChoices} {...props} />);
}

export default Form;