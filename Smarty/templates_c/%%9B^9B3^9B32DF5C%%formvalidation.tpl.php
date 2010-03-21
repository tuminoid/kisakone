<?php /* Smarty version 2.6.26, created on 2010-02-15 15:48:08
         compiled from javascript/formvalidation.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'javascript/formvalidation.tpl', 119, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%9B^9B3^9B32DF5C%%formvalidation.tpl.inc'] = 'ff8c0b26f9f07fa2595979b0a1f21ae9'; ?> <?php echo '
var fieldTests = new Array();
var fullTest = false;

var cancellingForm = false;

$("document").ready(function() {
    $("input").focus(DelayedValidationTest);
});

var DelayedTest;

function DelayedValidationTest() {
    
    var entry = DelayedTest;
    if (!entry) return;
    
    DelayedTest = null;
    
    //alert(\'here\');
    

	
    object = entry.delayedObject;
	    
    
    test = entry[0];
    arguments = entry[2];
    
    TestField(test, object, arguments);
    
    
}

function InitializeFormValidation(formName) {    
    if (fieldTests[formName] != null) return;
    fieldTests[formName] = new Array();

    
    $("#" + formName).submit(function() {
	return ValidateFullForm(formName);
    });
}

function CancelSubmit() {
    
    cancellingForm = true;
}

function FindField(form, field) {
    
    var element = $("#" + form + " :input[name=\'" + field + "\']");
    
    return element;
}

function CheckedFormField(form, field, test, arguments, options ) {

    
    InitializeFormValidation(form);
    var fieldobject = FindField(form, field);
    
    test(fieldobject, arguments, true);
    
    
    var entry = new Array( test, fieldobject, arguments );
    entry.options = options;

    
    fieldTests[form][field] = entry;
}

function ValidateFullForm(formName) {
    
    if (cancellingForm) {
	cancellingForm = false;
	return true;
    }
    
    var tests = fieldTests[formName];
    
    
    var allOk = true;
    fullTest = true;
    
    for (var index in tests) {
	
	var test  = tests[index];
	
	if (test[1] == null) continue;
	if (!TestField(test[0], test[1], test[2])) allOk = false;
    }
    
    fullTest = false;
    
    if (!allOk) {
	'; ?>

	alert("<?php if ($this->caching && !$this->_cache_including): echo '{nocache:ff8c0b26f9f07fa2595979b0a1f21ae9#0}'; endif;echo translate_smarty(array('id' => 'FormError_Summary','escape' => false), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:ff8c0b26f9f07fa2595979b0a1f21ae9#0}'; endif;?>
");
	<?php echo '
	return false;
	}
    
    return allOk;
}

function NonEmptyField(field, arguments, initialize) {
    if (initialize) {
	field.blur(TestField);	
    }
    else {
	
	//for (i in do)
	//if (field.attr("value") != "") return true;
	    
	
	if (getvalue(field) != "") return true;
	
	
	'; ?>

	return "<?php if ($this->caching && !$this->_cache_including): echo '{nocache:ff8c0b26f9f07fa2595979b0a1f21ae9#1}'; endif;echo translate_smarty(array('id' => 'FormError_NotEmpty','escape' => false), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:ff8c0b26f9f07fa2595979b0a1f21ae9#1}'; endif;?>
";
	<?php echo '
    }
    
}

function EmailField(field, arguments, initialize) {
    
    if (initialize) {
	field.blur(TestField);	
    }
    else {
	var value = getvalue(field);
	
	if (value.indexOf(\'@\') != -1 && value.indexOf(\'.\') != -1) return true;
	
	'; ?>

	return "<?php if ($this->caching && !$this->_cache_including): echo '{nocache:ff8c0b26f9f07fa2595979b0a1f21ae9#2}'; endif;echo translate_smarty(array('id' => 'FormError_InvalidEmail','escape' => false), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:ff8c0b26f9f07fa2595979b0a1f21ae9#2}'; endif;?>
";
	<?php echo '
    }
    
}

function RepeatedPasswordField(field, arguments, initialize) {
    
    if (initialize) {
	field.blur(TestField);	
    }
    else {
	
	var testField = $("#" + arguments);
	if (getvalue(field) == getvalue(testField)) return true;
	
	'; ?>

	return "<?php if ($this->caching && !$this->_cache_including): echo '{nocache:ff8c0b26f9f07fa2595979b0a1f21ae9#3}'; endif;echo translate_smarty(array('id' => 'FormError_PasswordsDontMatch','escape' => false), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:ff8c0b26f9f07fa2595979b0a1f21ae9#3}'; endif;?>
";
	<?php echo '
    }
    
}


function PositiveIntegerField(field, arguments, initialize) {
    if (initialize) {
	field.blur(TestField);	
    }
    else {
	var value = getvalue(field);
	if (arguments == true && value == "") return true;
	if (!isNaN(parseInt(value))) return true;
	
	'; ?>

	return "<?php if ($this->caching && !$this->_cache_including): echo '{nocache:ff8c0b26f9f07fa2595979b0a1f21ae9#4}'; endif;echo translate_smarty(array('id' => 'FormError_NotPositiveInteger','escape' => false), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:ff8c0b26f9f07fa2595979b0a1f21ae9#4}'; endif;?>
";
	<?php echo '
    }
    
}

function RadioFieldSet(field, arguments, initialize) {
    if (!initialize) {
	var fields;
	//if (field.form)	var fields = FindField(field.form.id, field.name);
	//else fields = field;
	
	if (field.is(":checked")) return true;
	
	
	'; ?>

	return "<?php if ($this->caching && !$this->_cache_including): echo '{nocache:ff8c0b26f9f07fa2595979b0a1f21ae9#5}'; endif;echo translate_smarty(array('id' => 'FormError_NotEmpty','escape' => false), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:ff8c0b26f9f07fa2595979b0a1f21ae9#5}'; endif;?>
";
	<?php echo '
    }
    
}

function AjaxField(field, arguments, initialize) {
    if (initialize) {
	field.blur(TestField);	
    }
    else {

	'; ?>

	jQuery.get("<?php echo $this->_tpl_vars['url_base']; ?>
ajaxCheck/" <?php echo ' + arguments, {username: getvalue(field)},
		   function(data) {		    
		    
			if (data == "OK") {
			    HideError(field);
			} else {
			    ShowError(field, data);
			}
		   }
		   , \'text\'
		   );
	
	return true;
    }
    
}

function OrangeField(field, arguments, initialize) {
    field.css("background-color", "orange");
}



function TestField(test, object, arguments) {
    
    if (object == null) {
	
	var entry = fieldTests[this.form.id][this.name];	

	
	object = $(this);
	        
	
	test = entry[0];
	arguments = entry[2];
	
	if (entry.options) {
	    
	    if (entry.options.delayed) {
		
		entry.delayedObject = $(this);
		DelayedTest = entry;
		return true;
	    }
	}
	
	
    } 
    
    //alert(fieldTests[this.form.id] == null);
    
    var result = test(object, arguments, false);
    
    if (result == true) {
	HideError(object);
    } else if (result == false) {
	DefaultError(object);
    } else {
	ShowError(object, result);
    }
    
    return result == true;
}

function ShowError(context, message) {    
    $(context).css("background-color", "#FDD")
    var ef = $(context).siblings(".fielderror");
    ef.show();
    ef.text(message);    
    
}

function HideError(context) {
    $(context).css("background-color", "")
    var ef = $(context).siblings(".fielderror");
    ef.hide();    
}

function getvalue(field) {
    return field.get()[0].value;
}

function DefaultError(context) {
    
'; ?>

    ShowError(context, "<?php if ($this->caching && !$this->_cache_including): echo '{nocache:ff8c0b26f9f07fa2595979b0a1f21ae9#6}'; endif;echo translate_smarty(array('id' => 'FormError_Default'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:ff8c0b26f9f07fa2595979b0a1f21ae9#6}'; endif;?>
");
<?php echo '
    }
    
    '; ?>