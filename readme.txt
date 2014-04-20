codeigniter form creator library

This is a simple library for easing use of form in Codeigniter.

After loading the library, you can add elements to form with "addElement()" method.

addElement("field name","field type","field title","rules","data base field name","default value","values");

field name=> the name of element.
field type=> type of element, in beta version you can just use {"text","password","dropdown"}
field title=> the title for using in error message or form labels.
rules=> is exactly the rules of form_validation class.
data base field name (optional)=> the name of field in database for storing form field value.
default value (optional)=> default field value especially used on editing data.
values (optional)=> array of dropdown list, just used when the "type" is "dropdown".

"setTemp()" method used for setting a custom template for each elements.
"{label-title}" will replace with element title.
"{input-place}" will replace with element.


"render("element name","options")" for rendering each form element by their name.

options=> for adding custom attributes to a form element.

"printAll()" prints all form elements.

"getDBData" returns an array of elemets and their values (just elemnts with setted DBname).





example:

in the controller:
        $this->load->library("form");

        $this->form->setTemp('<div class="form-group">
        <label for="login-userName"> {label-title}</label>
        {input-place}
        </div>');

        $this->form->addElement("name","text","name","trim|required","name","hamid");
        $this->form->addElement("pass","password","pass","trim|required","pass");


        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('auth/test',array("CI"=>$this));
        }
        else
        {
            $this->user_model->insertData($this->form->getDBData());
        }
        
        
in the view:
    <form class="form center-block register" method="post">
    
            <?php echo $CI->form->printAll() ?>
    
        <button type="submit" id="modal-login-btn" class="btn btn-default pull-left">ورود</button>
    </form>
    
or:
<form class="form center-block register" method="post">
    
            <?php echo $CI->form->render("name") ?>
            <?php echo $CI->form->render("pass",array("calss"=>"text-center")) ?>
    
        <button type="submit" id="modal-login-btn" class="btn btn-default pull-left">ورود</button>
    </form>
