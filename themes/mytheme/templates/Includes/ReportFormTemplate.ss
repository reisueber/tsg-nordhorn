<form $FormAttributes>
	<fieldset>
		$Fields.dataFieldByName(Datum)
		$Fields.dataFieldByName(Uhrzeit)
	</fieldset>

	<div class="Actions">
		<% loop $Actions %>$Field<% end_loop %>
	</div>
</form>