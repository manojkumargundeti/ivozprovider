import React, { useState } from 'react';
import { Tooltip, Fab } from '@mui/material';
import QueueIcon from '@mui/icons-material/Queue';
import SearchIcon from '@mui/icons-material/Search';
import { ContentFilter } from 'lib/components/List/Filter/ContentFilter';
import EntityService from 'lib/services/entity/EntityService';
import _ from 'lib/services/translations/translate';
import { StyledActionButtonContainer, StyledLink, StyledFab } from './ListContent.styles';
import { Box } from '@mui/system';
import ContentTable from './Table/ContentTable';
import ContentCard from './Card/ContentCard';
import { RouteMapItem } from 'lib/router/routeMapParser';
import { useLocation } from 'react-router-dom';
import { CancelToken } from 'axios';

interface ListContentProps {
  childEntities: Array<RouteMapItem>,
  path: string,
  entityService: EntityService,
  rows: any,
  ignoreColumn: string | undefined,
  preloadData: boolean,
  cancelToken: CancelToken,
}

export default function ListContent(props: ListContentProps): JSX.Element {
  const {
    childEntities,
    path,
    entityService,
    rows,
    ignoreColumn,
    preloadData,
    cancelToken
  } = props;

  const location = useLocation();
  const acl = entityService.getAcls();
  const [showFilters, setShowFilters] = useState(false);
  const handleFiltersClose = () => {
    setShowFilters(false);
  };

  const filterButtonHandler = (/*event: MouseEvent<HTMLButtonElement>*/) => {
    setShowFilters(!showFilters);
  };

  return (
    <React.Fragment>
      <StyledActionButtonContainer>
        <div />
        <div>
          <Tooltip title={_('Search')} arrow>
            <StyledFab onClick={filterButtonHandler}>
              <SearchIcon />
            </StyledFab>
          </Tooltip>
          {acl.create && <StyledLink to={`${location.pathname}/create`}>
            <Tooltip title="Add" enterTouchDelay={0} arrow>
              <Fab color="secondary" size="small" variant="extended">
                <QueueIcon />
              </Fab>
            </Tooltip>
          </StyledLink>}
        </div>
      </StyledActionButtonContainer>

      <ContentFilter
        entityService={entityService}
        open={showFilters}
        handleClose={handleFiltersClose}
        path={path}
        preloadData={preloadData}
        ignoreColumn={ignoreColumn}
        cancelToken={cancelToken}
      />

      <Box sx={{ display: { xs: 'none', md: 'block' } }}>
        <ContentTable
          entityService={entityService}
          rows={rows}
          ignoreColumn={ignoreColumn}
          path={path}
          childEntities={childEntities}
        />
      </Box>
      <Box sx={{ display: { xs: 'block', md: 'none' } }}>
        <ContentCard
          entityService={entityService}
          rows={rows}
          ignoreColumn={ignoreColumn}
          path={path}
          childEntities={childEntities}
        />
      </Box>
    </React.Fragment >
  );
}