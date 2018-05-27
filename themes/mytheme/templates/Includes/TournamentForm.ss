<form $FormAttributes class="foo">
	<fieldset class="form-row">
		<div class="col-md-4">$Fields.dataFieldByName(Datum)</div>
		<div class="col-md-4">$Fields.dataFieldByName(Uhrzeit)</div>
		<div class="col-md-4">$Fields.dataFieldByName(Turniernummer)</div>
	</fieldset>

	<div class="Actions">
		<% loop $Actions %>$Field<% end_loop %>
	</div>
</form>

<div class="form-row">
	<div class="col-7">
		<input type="text" class="form-control" placeholder="City">
	</div>
	<div class="col">
		<input type="text" class="form-control" placeholder="State">
	</div>
	<div class="col">
		<input type="text" class="form-control" placeholder="Zip">
	</div>
</div>

'Datum' => 'Date',
'Uhrzeit' => 'Time',
'Turniernummer' => 'Text',
'Ausrichter' => 'Text',
'Startgruppe' => 'Text',
'Klasse' => 'Text',
'Standard' => 'Boolean',
'Latein' => 'Boolean',