<div class="container">
	<div id="TournamentForm" class="row">
		<div class="col-md-12">
			<button class="button button-pill" v-on:click="show = !show">
				<i class="fa fa-minus-circle" v-if="show"></i>
				<i class="fa fa-plus-circle" v-else></i>
				&nbsp;{{ show ? 'Formular ausblenden' : 'Meldung erstellen' }}
			</button>

			<a href="meldeliste/showReportLibrary" class="button button-pill">
				<i class="fa fa-archive"></i> Archiv
			</a>
		</div>

		<% if $isReportLibrary %>
			<input type="text" id="searchFilterField" placeholder="Nach Datum suchen">
		<% end_if %>

		<transition name="fade" style="width: 100%">
			<!--TODO: v-if="show" bugfix IE und Firefox -->
			<div class="form-area col-md-12">
				$TournamentForm
			</div>
		</transition>
	</div>

	<div class="row">
		<table id="#reportlist" class="table">
			<thead>
			<tr>
				<th>Datum</th>
				<th>Uhrzeit</th>
				<th>Turniernr.</th>
				<th>Ausrichter</th>
				<th>Gruppe</th>
				<th>Gemeldet</th>
				<th>Name</th>
				<th></th>
			</tr>
			</thead>
			<tbody>
				<% loop $getReports %>
					<tr id="$ID" data-foo="$foo" class="<% if $isReportLibrary %><% else_if $isOld %>expired<% end_if %><% if $isOurEntry %> isOurEntry<% end_if %>">
						<td>$Datum.Nice</td>
						<td>$Uhrzeit</td>
						<td>$Turniernummer</td>
						<td>$Ausrichter</td>
						<td>$TournamentType</td>
						<td><span class="status-tag $StatusTagColor">$Status</span></td>
						<td>$Author.Name</td>
						<% if $Up.isSportwart %>
							<td><a href="edit-page?id=$ID"><i class="md-icon">create</i></a></td>
						<% end_if %>
					</tr>
				<% end_loop %>
			</tbody>
		</table>

		<% if $isSportwart %>
		<div class="controls">
			<button class="button button-pill button-small">Meldung erhalten</button>
			<button class="button button-pill button-small">Auslandsgenehmigung beantragt</button>
			<button class="button button-pill button-small">gemeldet</button>
			<button class="button button-pill button-small">Paar abgemeldet</button>
			<button class="button button-pill button-small">Turnier abgesagt</button>
			<button class="button button-pill button-small">Meldung abgelehnt</button>
		</div>
		<% end_if %>
	</div>

	<div class="row">
		<div class="col-md-12">Quelle:tanzsport.de</div>

		<div id="outerIframe" class="col-md-12">
			<iframe id="innerIframe" src="http://appsrv.tanzsport.de/dtv-webdbs/turnier/suche.spf" width="900" height="660" >
				<p>Your browser does not support iframes.</p>
			</iframe>
		</div>
	</div>
</div>