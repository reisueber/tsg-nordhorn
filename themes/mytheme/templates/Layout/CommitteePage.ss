<!-- CommitteePage -->

	<div class="row striped">
		<section class="col-md-12">

			<% loop $CommitteeMembers %>

				<div class="item member row">
					<div class="col-md-2">
						<div class="round-image small">
							<% if $profilImage %>
								<div class="image-wrapper" <% if $profilImageX %>style="top: {$profilImageY}px; left: {$profilImageX}px;"<% end_if %>>
									$profilImage
								</div>
							<% else %>
								<i class="fa fa-user"></i>
							<% end_if %>
						</div>
					</div>
					<div class="col-md-10 text">
						<div class="title">
							<div class="job"><h2>$committeePosition</h2></div>
							<div class="name">$FullName</div>
						</div>
						<div class="description">$committeeDescription</div>
					</div>
				</div>

			<% end_loop %>

		</section>
	</div>
