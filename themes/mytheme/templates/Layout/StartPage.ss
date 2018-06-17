<!-- StartPage-->
	<div class="row">
		<section class="col-md-6">
			<h1>News</h1>
			<table class="table table-hover table-striped">
				<tbody>
					<% loop $getStartPageNews.Sort(Date, DESC) %>
					<tr class='clickable-row' data-href='$Link'>
						<td>$MainImage.fit(100,100)</td>
						<td>
							$Date.Nice<br />
							<b>$Title</b><br />
							$Content.LimitCharacters(80)
						</td>
					</tr>
					<% end_loop %>
				</tbody>
			</table>
		</section>
		<section class="col-md-6">
			<h1>Termine</h1>
			<table class="table table-striped">
				<tbody>
					<% loop $ActiveEvents %>
						<tr>
							<td>$Date.Nice</td>
							<td>$Description</td>
						</tr>
					<% end_loop %>
				</tbody>
			</table>
		</section>
	</div>