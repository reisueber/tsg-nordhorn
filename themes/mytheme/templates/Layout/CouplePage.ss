<% with $getSelectedMember %>
	<div class="controller">
		<% if $isAdmin %><a href="/profil-edit?id=$ID" class="button button-pill back">bearbeiten</a><% end_if %>
		<a href="javascript: history.back()" class="button button-pill back">zurück</a>
	</div>

	<div class="striped">
		<section class="col-md-12">
			<!--<div class="header" style="width: 100%; height: 150px; background: url('http://tsg-nordhorn.de/assets/Uploads/1500346410515012482955548758030841367182790o.jpg')">
			</div>-->

			<div class="couple item row">
				<div class="danceProfilImage row col-md-6">
					<% loop $danceProfil %>
						<div class="round-image">$danceProfilImage</div>
					<% end_loop %>
				</div>

				<div class="dancer row col-md-3">
					<div class="image-name row col-md-12">
						<div class="image">
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
						<div class="text">
							<h2>$FirstName</h2>
						</div>
					</div>
					<div class="description col-md-12">
						<ul>
							<li>Hobbies: $hobbies</li>
							<li>tanzt seit: $danceSince</li>
							<li>Lieblingstänze: $favDances</li>
						</ul>
					</div>
				</div>
				
				<div class="partner row col-md-3">
						<div class="image-name row col-md-12">
							<div class="image">
								<div class="round-image small">
									<% if $partnerProfilImage %>
										<div class="image-wrapper" <% if $partnerProfilImageX %>style="top: {$partnerProfilImageY}px; left: {$partnerProfilImageX}px;"<% end_if %>>
											$partnerProfilImage
										</div>
									<% else %>
										<i class="fa fa-user"></i>
									<% end_if %>
								</div>
							</div>
							<div class="text">
								<h2>$partnerFirstName</h2>
							</div>
						</div>
						<div class="description col-md-12">
							<ul>
								<li>Hobbies: $partnerHobbies</li>
								<li>tanzt seit: $partnerDanceSince</li>
								<li>Lieblingstänze: $partnerFavDances</li>
							</ul>
						</div>

				</div>
			</div>

			<% loop $danceProfil %>
				<div class="item danceData">
					<h1>$danceGroup $danceClass Std.</h1>
					<p>tanzen zusammen seit: $danceTogetherSince</p>
				</div>
				<div class="item row">
					<div class="col-md-12 text">
						<div class="job"><h2>Erfolge</h2></div>
						<div class="description">$successes</div>
					</div>
				</div>
				<div class="item row">
					<div class="col-md-12 text">
						<div class="job"><h2>Ein paar kurze Worte:</h2></div>
						<div class="description">$description</div>
					</div>
				</div>
			<% end_loop %>

			<!--<div class="item">
				<h2>Fotos:</h2>
				<div class="col-md-12 photos row">
					<div class="photo"></div>
					<div class="photo"></div>
					<div class="photo"></div>
					<div class="photo"></div>
					<div class="photo"></div>
					<div class="photo"></div>
					<div class="photo"></div>
					<div class="photo"></div>
					<div class="photo"></div>
				</div>
			</div>-->
		</section>
	</div>
<% end_with %>
