<% if $IncludeFormTag %>
	<form $AttributesHTML>
<% end_if %>
<% if $Message %>
		<p id="{$FormName}_error" class="message $MessageType">$Message</p>
<% else %>
		<p id="{$FormName}_error" class="message $MessageType" style="display: none"></p>
<% end_if %>

	<fieldset>
		<% if $Legend %><legend>$Legend</legend><% end_if %>
		<el-time-select
  v-model="value1"
  :picker-options="{
    start: '08:30',
    step: '00:15',
    end: '18:30'
  }"
  placeholder="Select time">
</el-time-select>

		<div class="profil-group">
			<div class="profil-item">
				<label>Datum:</label>
				$Fields.dataFieldByName(Datum)
			</div>
			<div class="profil-item">
				<label>Uhrzeit:</label>
				$Fields.dataFieldByName(Uhrzeit)
			</div>
		</div>

		<div class="profil-group">
			<div class="profil-item">
				<label>Turniernr.:</label>
				$Fields.dataFieldByName(Turniernummer)
			</div>
			<div class="profil-item">
				<label>Ausrichter:</label>
				$Fields.dataFieldByName(Ausrichter)
			</div>
		</div>

		<div class="profil-group">
			<div class="profil-item">
				<label>Startgruppe:</label>
				$Fields.dataFieldByName(Startgruppe)
			</div>
			<div class="profil-item">
				<label>Klasse:</label>
				$Fields.dataFieldByName(Klasse)
			</div>
		</div>

		<div class="profil-group">
			<div class="profil-item">
				<label>Typ</label>
				$Fields.dataFieldByName(Type)
			</div>
		</div>

		<div class="profil-group">
			<div class="profil-item">
				<label>Platzierung:</label>
				$Fields.dataFieldByName(Platzierung)
			</div>
			<div class="profil-item">
				<label>Gesamtplatzierungen:</label>
				$Fields.dataFieldByName(Gesamtplatzierungen)
			</div>
		</div>
		<!-- hiddenFields -->
		$Fields.dataFieldByName(ReportId)
		$Fields.dataFieldByName(Status)
		<div class="clear"><!-- --></div>
	</fieldset>

<% if $Actions %>
		<div class="btn-toolbar">
			<% loop $Actions %>
				$Field
			<% end_loop %>
		</div>
<% end_if %>
<% if $IncludeFormTag %>
	</form>
<% end_if %>