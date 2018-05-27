<!-- PressHolderPage-->
	<div class="row">
		<aside class="col-md-3">
			<ul>
				<% loop $Menu(2).Reverse %>
					<li>
						<a href="$Title" class="$LinkingMode">
						<% if $LinkingMode == "current"  %><i class="fa fa-caret-right"></i><b><% end_if %>
						$Title <% if $LinkingMode == "current"  %></b><% end_if %>
						</a>
					</li>
					<hr width="100px" />
				<% end_loop %>
			</ul>
		</aside>

		<section class="col-md-9">
			<table class="table table-hover table-striped">
				<thead>
				<tr>
					<th scope="col">Datum</th>
					<th scope="col">Titel</th>
					<th scope="col">Orte</th>
				</tr>
				</thead>
				<tbody>
					<% loop $Children %>
						<tr class='clickable-row' data-href='$Link'>
							<td>$Date.Nice</td>
							<td>$Title</td>
							<td>$City</td>
						</tr>
					<% end_loop %>
				</tbody>
			</table>
		</section>
	</div>