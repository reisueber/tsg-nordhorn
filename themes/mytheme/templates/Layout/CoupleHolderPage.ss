<div class="controller">
	<% if $inactivePage %>
		<a href="/unsere-paare" class="button button-pill back">unsere aktiven Paare</a>
	<% else %>
		<a href="/unsere-paare?inactive=true" class="button button-pill back">unsere ehemaligen Paare</a>
	<% end_if %>
</div>
<!-- CouplePage -->
	<div class="row">
		<section class="col-md-12 table-responsive">
			<table class="table table-hover table-striped"cellpadding="5">
				<tbody>
					<% loop $Couples %>
						<tr class='clickable-row' data-href='/unsere-paare/detailseite/?id=$ID'>
							<td>
								<% loop $danceProfil %>
									<div class="round-image small">$danceProfilImage</div>
								<% end_loop %>
							</td>
							<td>
								<h2>$FirstName und $PartnerFirstName</h2><br />
								<% loop $danceProfil %>
									$danceGroup $danceClass
								<% end_loop %>
							</td>
						</tr>
					<% end_loop %>
				</tbody>
			</table>
		</section>
	</div>
