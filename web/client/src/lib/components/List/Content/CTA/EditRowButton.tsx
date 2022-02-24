import { Tooltip } from "@mui/material";
import { StyledTableRowCta } from "../Table/ContentTable.styles";
import _ from 'lib/services/translations/translate';
import EditIcon from '@mui/icons-material/Edit';
import { RouteComponentProps, withRouter } from "react-router-dom";
import buildLink from "../Shared/BuildLink";

type EditRowButtonProps = RouteComponentProps & {
    row: Record<string, any>,
    path: string
}

const EditRowButton = (props: EditRowButtonProps): JSX.Element => {

    const { row,  match } = props;
    const link = buildLink(match.path, match);

    return (
      <Tooltip title={_('Edit')} placement="bottom">
        <StyledTableRowCta to={`${link}/${row.id}/update`}>
          <EditIcon />
        </StyledTableRowCta>
      </Tooltip>
    );
  }

  export default withRouter(EditRowButton);