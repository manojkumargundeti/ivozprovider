import _ from '@irontec/ivoz-ui/services/translations/translate';
import { Link } from 'react-router-dom';

import { DashboardData } from '../@types';
import IconClientsDashboard from '../IconClients';
import IconPlatformsDashboard from '../IconPlatforms';
import IconUsersDashboard from '../IconUsers';

export const CardsAmountResidential = (props: DashboardData): JSX.Element => {
  const { ddiNum, voiceMailNum, residentialDeviceNum } = props;

  return (
    <>
      <div className='card amount'>
        <div className='img-container'>
          <IconPlatformsDashboard />
        </div>

        <div className='number'>{residentialDeviceNum}</div>

        <div className='name'>{_('Residential Device', { count: 2 })}</div>
        <Link to='/client/residential_devices' className='link'>
          {_('Go to Residential Devices')}
        </Link>
      </div>

      <div className='card amount'>
        <div className='img-container'>
          <IconClientsDashboard />
        </div>

        <div className='number'>{voiceMailNum}</div>

        <div className='name'>{_('Voice Mail', { count: 2 })}</div>

        <Link to='/client/voicemails' className='link'>
          {_('Go to Voice Mails')}
        </Link>
      </div>

      <div className='card amount'>
        <div className='img-container'>
          <IconUsersDashboard />
        </div>

        <div className='number'>{ddiNum}</div>

        <div className='name'>{_('DDI', { count: 2 })}</div>

        <Link to='/client/ddis' className='link'>
          {_('Go to DDIs')}
        </Link>
      </div>
    </>
  );
};
