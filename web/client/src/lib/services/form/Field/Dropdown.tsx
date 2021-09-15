import {
  FormControl,
  InputLabel,
  MenuItem,
  Select,
  OutlinedInput
} from '@mui/material';
import { JSXElementConstructor, ReactElement } from 'react';

interface SelectProps {
  name: string,
  label: string | ReactElement<any, string | JSXElementConstructor<any>>,
  value: any,
  required: boolean,
  disabled: boolean,
  onChange: (event: any) => void,
  choices: any
}

const Dropdown = (props: SelectProps) => {

  const { name, label, value, required, disabled, onChange, choices } = props;
  const labelId = `${name}-label`;

  return (
    <FormControl fullWidth={true}>
      <InputLabel required={required} shrink={true} id={labelId}>{label}</InputLabel>
      <Select
        value={value}
        disabled={disabled}
        onChange={onChange}
        displayEmpty={true}
        variant="outlined"
        input={
          <OutlinedInput
            name={name}
            type="text"
            label={label}
            notched={true}
          />
        }
      >
        {Object.entries(choices).map(([value, label]: [any, any], key: number) => {
          return (<MenuItem value={value} key={key}>{label}</MenuItem>);
        })}
      </Select>
    </FormControl>
  );
};

export default Dropdown;