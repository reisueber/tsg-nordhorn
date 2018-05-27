<div role="radiogroup" class="el-radio-group" $AttributesHTML>
	<% loop $Options %>
		<label role="radio" tabindex="0" class="el-radio-button is-active" aria-checked="true">
			<input id="$ID" class="el-radio-button__orig-radio" name="$Name" type="radio" value="$Value"<% if $isChecked %> checked<% end_if %><% if $isDisabled %> disabled<% end_if %> <% if $Up.Required %>required<% end_if %> >
			<span class="el-radio-button__inner">$Title</span>
		</label>
	<% end_loop %>
</div>