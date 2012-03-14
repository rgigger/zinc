{block name="body"}
{openform action=$virtualUrl id="passwordReset"}
<h2>Reset Your Password</h2>

Password {input data_object=$person data_field="password" type="password" required=true sameas="password2" id="password"}<br>
Verify (Re-enter) {input type="password" name="password2" required=true id="password2"}<br>
<input class="button" id="resetBUTTON" type="submit" name="" value="Submit" title="Submit" /><br>

{closeform}
{/block}