/*
 * Copyright (c) 2013, MasterCard International Incorporated
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without modification, are 
 * permitted provided that the following conditions are met:
 * 
 * Redistributions of source code must retain the above copyright notice, this list of 
 * conditions and the following disclaimer.
 * Redistributions in binary form must reproduce the above copyright notice, this list of 
 * conditions and the following disclaimer in the documentation and/or other materials 
 * provided with the distribution.
 * Neither the name of the MasterCard International Incorporated nor the names of its 
 * contributors may be used to endorse or promote products derived from this software 
 * without specific prior written permission.
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY 
 * EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES 
 * OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT 
 * SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, 
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED
 * TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; 
 * OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER 
 * IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING 
 * IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF 
 * SUCH DAMAGE.
 */

var digitsOnly = function(event) {
  if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 ||
       event.keyCode == 27 || event.keyCode == 13 || 
      (event.keyCode == 65 && event.ctrlKey === true) || 
      (event.keyCode >= 35 && event.keyCode <= 39)) {
        return;
  }
  else {
    if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
      event.preventDefault(); 
    }   
  }
}

var luhn_validate = function(imei){
  var luhn = function(imei) {
    var t, n, p, i, s;
    p = !0, s = 0, n = imei.split("").reverse();
    for (i = 0; i < n.length; i++) {
     t = parseInt(n[i], 10);
     if (p = !p) t *= 2;
     t > 9 && (t -= 9); 
     s += t;
   }
   return s % 10 === 0;
 }
 return /^\d+$/.test(imei) && luhn(imei);
};

var highlightInvalidField = function(elName) {
  $("#"+elName).addClass("invalid");
}

var removeInvalidHighlight = function(elName) {
  $("#"+elName).removeClass("invalid");
}

var validator = function(el, value, rules, errMsg, validateFunc, id) {
  id = typeof id == 'undefined'? el.getAttribute("id") : id;
  if (!rules(value)) {
    highlightInvalidField(id);
    if (!jQuery._data(el, "events").keyup) {
      $("input#"+el.getAttribute('id')).keyup(function() {
        validateFunc(this, this.value);
      });
    }
    return false;
  } else {
    removeInvalidHighlight(id);
    return true;
  }
}

var creditCardValidator = function (el, value) {
  var creditCardNumberRules = function (value) {
    value = value.replace(/ /g, '');
    return value.length >= 13 && value.length <= 19 && luhn_validate(value);
  }
  return validator(el, value, creditCardNumberRules, "Please provide a valid credit card number.", creditCardValidator);
}

var cvcValidator = function(el, value) {
  var cvcRules = function(value) {
    return value.length >= 3 && value.length <= 4 && /^\d+$/.test(value);
  }
  return validator(el, value, cvcRules, "Please provide a valid CVC number.", cvcValidator);
}

var nameValidator = function(el, value) {
  var nameRules = function(value) {return value.length > 1;}
  return validator(el, value, nameRules, "Please provide at least 2 characters.", nameValidator);
}

var zipValidator = function(el, value) {
  var zipRules = function(value) {return value.length > 4;}
  return validator(el, value, zipRules, "Please provide a valid zip code.", zipValidator, 'zip');
}

var addressValidator = function(el, value) {
  var addressRules = function(value) {return value.length > 3;}
  return validator(el, value, addressRules, "Please provide at least 4 characters.", addressValidator);
}

var cityValidator = function(el, value) {
  var cityRules = function(value) {return value.length > 1;}
  return validator(el, value, cityRules, "Please provide at least 2 characters.", cityValidator);
}

var expValidator = function(el, value) {
  var expRules = function (value) {
    var time = new Date();
    if (parseInt($("#exp_year").val()) + 2000 > time.getFullYear() || parseInt($("#exp_month").val()) > time.getMonth())
      return true;
    return false;
  }
  return validator(el, value, expRules, "Please provide a valid expiry date.", expValidator, "exp_month");
}

var fieldValidation = function(field_validator, el) {
  return field_validator(el, el.value);
}

var overallValidation = function() {
  return fieldValidation(creditCardValidator, $("input#pan")[0]) &
    fieldValidation(expValidator, $("select#exp_month")[0]) &
    fieldValidation(cvcValidator, $("input#cvc")[0]) &
    fieldValidation(nameValidator, $("input#name_on_card")[0]) &
    fieldValidation(addressValidator, $("input#address")[0]) & 
    fieldValidation(cityValidator, $("input#city")[0]) & 
    fieldValidation(zipValidator, $("input#zip")[0]);
}
