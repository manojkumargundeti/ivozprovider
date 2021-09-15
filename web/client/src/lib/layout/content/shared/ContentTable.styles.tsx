import { Theme, Fab, Chip } from '@mui/material';
import { styled } from '@mui/styles';
import { Link } from "react-router-dom";

export const StyledActionButtonContainer = styled('div')(
  ({ theme }: { theme: Theme }) => {
    return {
      display: 'flex',
      justifyContent: 'space-between',
      '& > div:nth-child(n+1)': {
        alignContent: 'flex-end'
      }
    }
  }
);

export const StyledLink = styled(
  (props) => {
    const { children, className, to } = props;
    return (<Link to={to} className={className}>{children}</Link>);
  }
)(
  ({ theme }: { theme: Theme }) => {
    return {
      textDecoration: 'none',
      color: 'inherit',
    }
  }
);

export const StyledFab = styled(
  (props) => {
    const { children, className, onClick } = props;
    return (
      <Fab
        color="secondary"
        size="small"
        variant="extended"
        className={className}
        onClick={onClick}
      >
        {children}
      </Fab>
    );
  }
)(
  ({ theme }: { theme: Theme }) => {
    return {
      marginRight: '10px'
    }
  }
);

export const StyledChip = styled(
  (props) => {
    const { className, icon, label, onDelete } = props;
    return (
      <Chip
        icon={icon}
        label={label}
        onDelete={onDelete}
        className={className}
      />
    );
  }
)(
  ({ theme }: { theme: Theme }) => {
    return {
      margin: '0 5px',
    }
  }
);

export const StyledChipIcon = styled(
  (props) => {
    const { children, className, fieldName } = props;
    return (
      <div className={className}>
        <span className='prefix'>{fieldName}</span>
        {children}
      </div>
    );
  }
)(
  ({ theme }: { theme: Theme }) => {
    return {
      paddingTop: '5px',
      '* .prefix': {
        display: 'inline-flex',
        userSelect: 'none',
        paddingLeft: '12px',
        paddingRight: '5px',
        verticalAlign: 'super',
      }
    }
  }
);