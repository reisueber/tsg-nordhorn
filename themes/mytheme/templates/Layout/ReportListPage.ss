<div id="TournamentForm" class="container">
	<div class="row actions">
		<div class="col-md-12">
			<button class="button button-pill" type="button" v-on:click='show = !show' v-cloak>
				<i class="fa fa-list" v-if="show"></i>
				<i class="fa fa-plus-circle" v-else></i>
				&nbsp;{{ show ? 'Meldeliste anzeigen' : 'Meldung erstellen' }}
			</button>

			<a href="meldeliste/showReportLibrary" class="button button-pill action">
				<i class="fa fa-archive"></i> Archiv
			</a>
		</div>
		<div class="col-md-12" v-if="!show">
			<br />
			Um eine Meldung zu erfassen, einmal auf "Meldung erstellen" klicken.
		</div>

		<% if $isReportLibrary %>
			<input type="text" id="searchFilterField" placeholder="Nach Datum suchen">
		<% end_if %>

		<div class="col-md-12 alert alert-warning mt-4" role="alert" v-if="show">
            Bitte informiert euch beim Veranstalter, ob beim Veranstalter eine zusätzliche Anmeldung erforderlich ist.
        </div>

		<transition name="fade" style="width: 100%">
			<div class="form-area col-md-12" v-if="show">
				$TournamentForm
			</div>
		</transition>
	</div>

	<div class="row" v-if="!show">
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
						<% if $Up.isSportwart || $isOurEntry %>
						<td>
							<% if $Up.isSportwart %>
								<a href="edit-page?id=$ID"><i class="fa fa-edit"></i></a>
							<% end_if %>
							<% if $isOurEntry %>
								<a href="delete-page?id=$ID"><i class="fa fa-trash-alt"></i></a>
							<% end_if %>
						</td>
						<% end_if %>
					</tr>
				<% end_loop %>
			</tbody>
		</table>

		<% if $isSportwart %>
		<div class="controls">
			<button class="button action button-pill button-small">Meldung erhalten</button>
			<button class="button action button-pill button-small">Auslandsgenehmigung beantragt</button>
			<button class="button action button-pill button-small">gemeldet</button>
			<button class="button action button-pill button-small">Paar abgemeldet</button>
			<button class="button action button-pill button-small">Turnier abgesagt</button>
			<button class="button action button-pill button-small">Meldung abgelehnt</button>
			<button class="button action button-pill button-small">Turnier löschen</button>
		</div>
		<% end_if %>
	</div>

	<div class="row" v-if="show">
		<div class="col-md-12">
            <a href="https://www.tanzsport.de/de/sportwelt/standard-und-latein/turnierdatenbank"
               style="text-decoration: underline"
               target="_blank">
                Turnierdatenbank auf tanzsport.de
            </a>
        </div>

		<!--<div id="outerIframe" class="col-md-12">
			<iframe id="innerIframe" src="https://www.tanzsport.de/de/sportwelt/standard-und-latein/turnierdatenbank" width="900" height="660" >
				<p>Your browser does not support iframes.</p>
			</iframe>
		</div>-->
	</div>
</div>
