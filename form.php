<?php

class FormElement
{
    private $name, $type,$title, $options, $values,$DBName,$value;

    public function FormElement($name, $type,$title,$DBName,$value, $values)
    {
        $this->name = $name;
        $this->type = $type;
        $this->values = $values;
        $this->title=$title;
        $this->DBName=$DBName;
        $this->value=$value;
    }

    public function render($options)
    {
        $output='';
        $this->options=$options;

        if ($this->type == 'password' || $this->type == "text") {
            $output = '<input type="' . $this->type . '" name="' . $this->name . '" ';

            if($this->type!='password')
                $output.='value="'.set_value($this->name,$this->value).'" ';

            $keys = array_keys($this->options);
            foreach ($keys as $key)
                $output .= $key . '="' . $this->options[$key] . '" ';

            $output .= ' />';
        }

        if ($this->type=='dropdown')
        {
            $options='';
            $keys = array_keys($this->options);
            foreach ($keys as $key)
                $options .= $key . '= "' . $this->options[$key] . '" ';

            $output = form_dropdown($this->name, $this->values, set_value($this->name,$this->value), $options);

        }

        return $output;
    }

    public function getDBName()
    {
        return $this->DBName;
    }

    public function getTitle()
    {
        return $this->title;
    }
}



class Form
{
    private $elements,$CI,$edit,$temp;

    public function Form($edit=false)
    {
        $this->CI=& get_instance();
        $this->edit=$edit;
    }

    public function addElement($name,$type,$title,$rules,$DBName='',$value='',$values=array())
    {
        $this->elements[$name]=new FormElement($name,$type,$title,$DBName,$value,$values);
        $this->CI->form_validation->set_rules($name, $title, $rules);

    }

    public function render($name,$options=array())
    {
        //print_r($this->elements[$name]);
        $eln=$this->elements[$name]->render($options);

        $output = str_replace('{label-title}',$this->elements[$name]->getTitle(),$this->temp);
        $output = str_replace('{input-place}',$eln,$output);

        return $output;
    }

    public function getDBData()
    {
        $keys = array_keys($this->elements);
        foreach ($keys as $key)
            if($this->elements[$key]->getDBName()!='')
                $arr[$key]=$this->CI->input->post($key);

        return $arr;
    }

    public function setTemp($temp)
    {
        $this->temp=$temp;
    }


    public function printAll()
    {
        $output='';
        $keys = array_keys($this->elements);
        foreach ($keys as $key)
            $output.=$this->render($key);

        return $output;
    }

}

?>