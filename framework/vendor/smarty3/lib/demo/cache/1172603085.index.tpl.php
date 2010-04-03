<?php if(!defined('SMARTY_DIR')) exit('no direct access allowed'); ?>
<?php $_smarty_tpl->decodeProperties('a:2:{s:15:"file_dependency";a:4:{s:10:"F384501455";a:2:{i:0;s:21:"./templates/index.tpl";i:1;i:1257977415;}s:11:"F1129582534";a:2:{i:0;s:22:"./templates/header.tpl";i:1;i:1257977415;}s:11:"F1159251177";a:2:{i:0;s:22:"./templates/footer.tpl";i:1;i:1257977415;}s:11:"F1337619037";a:2:{i:0;s:19:"./configs/test.conf";i:1;i:1257977415;}}s:14:"cache_lifetime";i:120;}'); ?>
<HTML>
<HEAD>
<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>
<script type="text/javascript" language="JavaScript" src="/javascripts/overlib.js"></script>
<TITLE>foo - <?php echo $_smarty_tpl->getVariable('Name')->value;?>
</TITLE>
</HEAD>
<BODY bgcolor="#ffffff">

<PRE>


<b>
Title: Welcome To Smarty!
</b>
The current date and time is 2009-11-12 11:53:15

The value of global assigned variable $SCRIPT_NAME is index.php

Example of accessing server environment variable SERVER_NAME: 

The value of {$Name} is <b><?php echo $_smarty_tpl->getVariable('Name')->value;?>
</b>

variable modifier example of {$Name|upper}

<b><?php echo $_smarty_tpl->smarty->plugin_handler->executeModifier('upper',array($_smarty_tpl->getVariable('Name')->value),true);?>
</b>


An example of a section loop:

	1 * John Doe
	2 * Mary Smith
	3 . James Johnson
	4 . Henry Case

An example of section looped key values:

	phone: 1<br>
	fax: 2<br>
	cell: 3<br>
	phone: 555-4444<br>
	fax: 555-3333<br>
	cell: 760-1234<br>
<p>

testing strip tags
<table border=0><tr><td><A HREF="index.php"><font color="red">This is a  test     </font></A></td></tr></table>

</PRE>

This is an example of the html_select_date function:

<form>
<select name="Date_Month">
<option label="January" value="01">January</option>
<option label="February" value="02">February</option>
<option label="March" value="03">March</option>
<option label="April" value="04">April</option>
<option label="May" value="05">May</option>
<option label="June" value="06">June</option>
<option label="July" value="07">July</option>
<option label="August" value="08">August</option>
<option label="September" value="09">September</option>
<option label="October" value="10">October</option>
<option label="November" value="11" selected="selected">November</option>
<option label="December" value="12">December</option>
</select>
<select name="Date_Day">
<option label="01" value="1">01</option>
<option label="02" value="2">02</option>
<option label="03" value="3">03</option>
<option label="04" value="4">04</option>
<option label="05" value="5">05</option>
<option label="06" value="6">06</option>
<option label="07" value="7">07</option>
<option label="08" value="8">08</option>
<option label="09" value="9">09</option>
<option label="10" value="10">10</option>
<option label="11" value="11">11</option>
<option label="12" value="12" selected="selected">12</option>
<option label="13" value="13">13</option>
<option label="14" value="14">14</option>
<option label="15" value="15">15</option>
<option label="16" value="16">16</option>
<option label="17" value="17">17</option>
<option label="18" value="18">18</option>
<option label="19" value="19">19</option>
<option label="20" value="20">20</option>
<option label="21" value="21">21</option>
<option label="22" value="22">22</option>
<option label="23" value="23">23</option>
<option label="24" value="24">24</option>
<option label="25" value="25">25</option>
<option label="26" value="26">26</option>
<option label="27" value="27">27</option>
<option label="28" value="28">28</option>
<option label="29" value="29">29</option>
<option label="30" value="30">30</option>
<option label="31" value="31">31</option>
</select>
<select name="Date_Year">
<option label="1998" value="1998">1998</option>
<option label="1999" value="1999">1999</option>
<option label="2000" value="2000">2000</option>
<option label="2001" value="2001">2001</option>
<option label="2002" value="2002">2002</option>
<option label="2003" value="2003">2003</option>
<option label="2004" value="2004">2004</option>
<option label="2005" value="2005">2005</option>
<option label="2006" value="2006">2006</option>
<option label="2007" value="2007">2007</option>
<option label="2008" value="2008">2008</option>
<option label="2009" value="2009" selected="selected">2009</option>
<option label="2010" value="2010">2010</option>
</select></form>

This is an example of the html_select_time function:

<form>
<select name="Time_Hour">
<option label="01" value="01">01</option>
<option label="02" value="02">02</option>
<option label="03" value="03">03</option>
<option label="04" value="04">04</option>
<option label="05" value="05">05</option>
<option label="06" value="06">06</option>
<option label="07" value="07">07</option>
<option label="08" value="08">08</option>
<option label="09" value="09">09</option>
<option label="10" value="10">10</option>
<option label="11" value="11" selected="selected">11</option>
<option label="12" value="12">12</option>
</select>
<select name="Time_Minute">
<option label="00" value="00">00</option>
<option label="01" value="01">01</option>
<option label="02" value="02">02</option>
<option label="03" value="03">03</option>
<option label="04" value="04">04</option>
<option label="05" value="05">05</option>
<option label="06" value="06">06</option>
<option label="07" value="07">07</option>
<option label="08" value="08">08</option>
<option label="09" value="09">09</option>
<option label="10" value="10">10</option>
<option label="11" value="11">11</option>
<option label="12" value="12">12</option>
<option label="13" value="13">13</option>
<option label="14" value="14">14</option>
<option label="15" value="15">15</option>
<option label="16" value="16">16</option>
<option label="17" value="17">17</option>
<option label="18" value="18">18</option>
<option label="19" value="19">19</option>
<option label="20" value="20">20</option>
<option label="21" value="21">21</option>
<option label="22" value="22">22</option>
<option label="23" value="23">23</option>
<option label="24" value="24">24</option>
<option label="25" value="25">25</option>
<option label="26" value="26">26</option>
<option label="27" value="27">27</option>
<option label="28" value="28">28</option>
<option label="29" value="29">29</option>
<option label="30" value="30">30</option>
<option label="31" value="31">31</option>
<option label="32" value="32">32</option>
<option label="33" value="33">33</option>
<option label="34" value="34">34</option>
<option label="35" value="35">35</option>
<option label="36" value="36">36</option>
<option label="37" value="37">37</option>
<option label="38" value="38">38</option>
<option label="39" value="39">39</option>
<option label="40" value="40">40</option>
<option label="41" value="41">41</option>
<option label="42" value="42">42</option>
<option label="43" value="43">43</option>
<option label="44" value="44">44</option>
<option label="45" value="45">45</option>
<option label="46" value="46">46</option>
<option label="47" value="47">47</option>
<option label="48" value="48">48</option>
<option label="49" value="49">49</option>
<option label="50" value="50">50</option>
<option label="51" value="51">51</option>
<option label="52" value="52">52</option>
<option label="53" value="53" selected="selected">53</option>
<option label="54" value="54">54</option>
<option label="55" value="55">55</option>
<option label="56" value="56">56</option>
<option label="57" value="57">57</option>
<option label="58" value="58">58</option>
<option label="59" value="59">59</option>
</select>
<select name="Time_Second">
<option label="00" value="00">00</option>
<option label="01" value="01">01</option>
<option label="02" value="02">02</option>
<option label="03" value="03">03</option>
<option label="04" value="04">04</option>
<option label="05" value="05">05</option>
<option label="06" value="06">06</option>
<option label="07" value="07">07</option>
<option label="08" value="08">08</option>
<option label="09" value="09">09</option>
<option label="10" value="10">10</option>
<option label="11" value="11">11</option>
<option label="12" value="12">12</option>
<option label="13" value="13">13</option>
<option label="14" value="14">14</option>
<option label="15" value="15" selected="selected">15</option>
<option label="16" value="16">16</option>
<option label="17" value="17">17</option>
<option label="18" value="18">18</option>
<option label="19" value="19">19</option>
<option label="20" value="20">20</option>
<option label="21" value="21">21</option>
<option label="22" value="22">22</option>
<option label="23" value="23">23</option>
<option label="24" value="24">24</option>
<option label="25" value="25">25</option>
<option label="26" value="26">26</option>
<option label="27" value="27">27</option>
<option label="28" value="28">28</option>
<option label="29" value="29">29</option>
<option label="30" value="30">30</option>
<option label="31" value="31">31</option>
<option label="32" value="32">32</option>
<option label="33" value="33">33</option>
<option label="34" value="34">34</option>
<option label="35" value="35">35</option>
<option label="36" value="36">36</option>
<option label="37" value="37">37</option>
<option label="38" value="38">38</option>
<option label="39" value="39">39</option>
<option label="40" value="40">40</option>
<option label="41" value="41">41</option>
<option label="42" value="42">42</option>
<option label="43" value="43">43</option>
<option label="44" value="44">44</option>
<option label="45" value="45">45</option>
<option label="46" value="46">46</option>
<option label="47" value="47">47</option>
<option label="48" value="48">48</option>
<option label="49" value="49">49</option>
<option label="50" value="50">50</option>
<option label="51" value="51">51</option>
<option label="52" value="52">52</option>
<option label="53" value="53">53</option>
<option label="54" value="54">54</option>
<option label="55" value="55">55</option>
<option label="56" value="56">56</option>
<option label="57" value="57">57</option>
<option label="58" value="58">58</option>
<option label="59" value="59">59</option>
</select>
<select name="Time_Meridian">
<option label="AM" value="am" selected="selected">AM</option>
<option label="PM" value="pm">PM</option>
</select>
</form>

This is an example of the html_options function:

<form>
<select name=states>
<option label="New York" value="NY">New York</option>
<option label="Nebraska" value="NE" selected="selected">Nebraska</option>
<option label="Kansas" value="KS">Kansas</option>
<option label="Iowa" value="IA">Iowa</option>
<option label="Oklahoma" value="OK">Oklahoma</option>
<option label="Texas" value="TX">Texas</option>
</select>
</form>

</BODY>
</HTML>
