{**
 * Suomen Frisbeeliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 *
 * Form field validation support
 *
 * --
 *
 * This file is part of Kisakone.
 * Kisakone is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Kisakone is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with Kisakone.  If not, see <http://www.gnu.org/licenses/>.
 * *}
 {literal}
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

    //alert('here');



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

    var element = $("#" + form + " :input[name='" + field + "']");

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
	{/literal}
	alert("{translate id=FormError_Summary escape=false}");
	{literal}
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


	{/literal}
	return "{translate id=FormError_NotEmpty escape=false}";
	{literal}
    }

}

function EmailField(field, arguments, initialize) {

    if (initialize) {
	field.blur(TestField);
    }
    else {
	var value = getvalue(field);

	if (value.indexOf('@') != -1 && value.indexOf('.') != -1) return true;

	{/literal}
	return "{translate id=FormError_InvalidEmail escape=false }";
	{literal}
    }

}

function RepeatedPasswordField(field, arguments, initialize) {

    if (initialize) {
	field.blur(TestField);
    }
    else {

	var testField = $("#" + arguments);
	if (getvalue(field) == getvalue(testField)) return true;

	{/literal}
	return "{translate id=FormError_PasswordsDontMatch escape=false}";
	{literal}
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

	{/literal}
	return "{translate id=FormError_NotPositiveInteger escape=false}";
	{literal}
    }

}

function RadioFieldSet(field, arguments, initialize) {
    if (!initialize) {
	var fields;
	//if (field.form)	var fields = FindField(field.form.id, field.name);
	//else fields = field;

	if (field.is(":checked")) return true;


	{/literal}
	return "{translate id=FormError_NotEmpty escape=false}";
	{literal}
    }

}

function AjaxField(field, arguments, initialize) {
    if (initialize) {
	field.blur(TestField);
    }
    else {

	{/literal}
	jQuery.get("{$url_base}ajaxCheck/" {literal} + arguments, {username: getvalue(field)},
		   function(data) {

			if (data == "OK") {
			    HideError(field);
			} else {
			    ShowError(field, data);
			}
		   }
		   , 'text'
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

{/literal}
    ShowError(context, "{translate id=FormError_Default}");
{literal}
    }

    {/literal}