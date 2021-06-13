<dl class="form_group">
<dt class="form_group__name"><label class="form_group__label" for="form_name">Text</label><span class="form_required">※</span></dt>
<dd class="form_group__body">
[text* form_name id:form_name class:form_control]
</dd>
</dl>

<dl class="form_group -zip">
<dt class="form_group__name"><label class="form_group__label" for="form_zip01">Zip</label></dt>
<dd class="form_group__body">
[number form_zip01 id:form_zip01 class:form_control]
<span class="__hyphen">-</span>
[number form_zip02 id:form_zip02 class:form_control]
</dd>
</dl>

<dl class="form_group">
<dt class="form_group__name"><label class="form_group__label" for="form_address01">Address01</label></dt>
<dd class="form_group__body">
<div class="form_control_select_wrap">
<span class="wpcf7-form-control-wrap form_address01">
<select name="form_address01" class="wpcf7-form-control wpcf7-select wpcf7-validates-as-required form_control_select" id="form_address01" aria-required="true" aria-invalid="false">
<option value="">option</option>
<option value="宮城県">宮城県</option>
</select>
</span>
</div>
</dd>
</dl>

<dl class="form_group">
<dt class="form_group__name"><label class="form_group__label" for="form_address02">Address02</label></dt>
<dd class="form_group__body">
[text form_address02 id:form_address02 class:form_control]
</dd>
</dl>

<dl class="form_group">
<dt class="form_group__name"><label class="form_group__label" for="form_address03">Address03</label></dt>
<dd class="form_group__body">
[text form_address03 id:form_address03 class:form_control]
</dd>
</dl>

<dl class="form_group">
<dt class="form_group__name"><label class="form_group__label" for="form_email">Email</label><span class="form_required">※</span></dt>
<dd class="form_group__body">
[email* form_email id:form_email class:form_control]
</dd>
</dl>

<dl class="form_group">
<dt class="form_group__name"><label class="form_group__label" for="form_email_confirm">Email_confirm</label><span class="form_required">※</span></dt>
<dd class="form_group__body">
[email* form_email_confirm id:form_email_confirm class:form_control]
</dd>
</dl>

<dl class="form_group">
<dt class="form_group__name"><label class="form_group__label" for="form_textarea">Textarea</label></dt>
<dd class="form_group__body">
[textarea form_textarea id:form_textarea class:form_control_textarea]
</dd>
</dl>

<dl class="form_group">
<dt class="form_group__name"><label class="form_group__label" for="form_point">Radio</label></dt>
<dd class="form_group__body form_control_radio_wrap">
[radio form_point id:form_point class:form_control_radio use_label_element default:1 "item1" "item2"]
</dd>
</dl>

<div class="form_group -agree">
<span class="wpcf7-form-control-wrap form_agree">
[checkbox* form_agree id:form_agree class:form_control_check use_label_element "agree"]
</div>

<div class="form_button_wrap">
<span class="form_button">
[submit "submit"]
</span>
</div>
