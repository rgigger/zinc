/*
 * Ext JS Library 1.1 Beta 2
 * Copyright(c) 2006-2007, Ext JS, LLC.
 * licensing@extjs.com
 * 
 * http://www.extjs.com/license
 */


Ext.form.DateField=function(_1){Ext.form.DateField.superclass.constructor.call(this,_1);if(typeof this.minValue=="string"){this.minValue=this.parseDate(this.minValue);}if(typeof this.maxValue=="string"){this.maxValue=this.parseDate(this.maxValue);}this.ddMatch=null;if(this.disabledDates){var dd=this.disabledDates;var re="(?:";for(var i=0;i<dd.length;i++){re+=dd[i];if(i!=dd.length-1){re+="|";}}this.ddMatch=new RegExp(re+")");}};Ext.extend(Ext.form.DateField,Ext.form.TriggerField,{format:"m/d/y",altFormats:"m/d/Y|m-d-y|m-d-Y|m/d|m-d|md|mdy|mdY|d",disabledDays:null,disabledDaysText:"Disabled",disabledDates:null,disabledDatesText:"Disabled",minValue:null,maxValue:null,minText:"The date in this field must be equal to or after {0}",maxText:"The date in this field must be equal to or before {0}",invalidText:"{0} is not a valid date - it must be in the format {1}",triggerClass:"x-form-date-trigger",defaultAutoCreate:{tag:"input",type:"text",size:"10",autocomplete:"off"},validateValue:function(_5){_5=this.formatDate(_5);if(!Ext.form.DateField.superclass.validateValue.call(this,_5)){return false;}if(_5.length<1){return true;}var _6=_5;_5=this.parseDate(_5);if(!_5){this.markInvalid(String.format(this.invalidText,_6,this.format));return false;}var _7=_5.getTime();if(this.minValue&&_7<this.minValue.getTime()){this.markInvalid(String.format(this.minText,this.formatDate(this.minValue)));return false;}if(this.maxValue&&_7>this.maxValue.getTime()){this.markInvalid(String.format(this.maxText,this.formatDate(this.maxValue)));return false;}if(this.disabledDays){var _8=_5.getDay();for(var i=0;i<this.disabledDays.length;i++){if(_8===this.disabledDays[i]){this.markInvalid(this.disabledDaysText);return false;}}}var _a=this.formatDate(_5);if(this.ddMatch&&this.ddMatch.test(_a)){this.markInvalid(String.format(this.disabledDatesText,_a));return false;}return true;},validateBlur:function(){return!this.menu||!this.menu.isVisible();},getValue:function(){return this.parseDate(Ext.form.DateField.superclass.getValue.call(this))||"";},setValue:function(_b){Ext.form.DateField.superclass.setValue.call(this,this.formatDate(this.parseDate(_b)));},parseDate:function(_c){if(!_c||_c instanceof Date){return _c;}var v=Date.parseDate(_c,this.format);if(!v&&this.altFormats){if(!this.altFormatsArray){this.altFormatsArray=this.altFormats.split("|");}for(var i=0,_f=this.altFormatsArray.length;i<_f&&!v;i++){v=Date.parseDate(_c,this.altFormatsArray[i]);}}return v;},formatDate:function(_10){return(!_10||!(_10 instanceof Date))?_10:_10.dateFormat(this.format);},menuListeners:{select:function(m,d){this.setValue(d);},show:function(){this.onFocus();},hide:function(){this.focus.defer(10,this);var ml=this.menuListeners;this.menu.un("select",ml.select,this);this.menu.un("show",ml.show,this);this.menu.un("hide",ml.hide,this);}},onTriggerClick:function(){if(this.disabled){return;}if(this.menu==null){this.menu=new Ext.menu.DateMenu();}Ext.apply(this.menu.picker,{minDate:this.minValue,maxDate:this.maxValue,disabledDatesRE:this.ddMatch,disabledDatesText:this.disabledDatesText,disabledDays:this.disabledDays,disabledDaysText:this.disabledDaysText,format:this.format,minText:String.format(this.minText,this.formatDate(this.minValue)),maxText:String.format(this.maxText,this.formatDate(this.maxValue))});this.menu.on(Ext.apply({},this.menuListeners,{scope:this}));this.menu.picker.setValue(this.getValue()||new Date());this.menu.show(this.el,"tl-bl?");},beforeBlur:function(){var v=this.parseDate(this.getRawValue());if(v){this.setValue(v);}}});