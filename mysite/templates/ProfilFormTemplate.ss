<% if $IncludeFormTag %>
	<form $AttributesHTML class="mytemplate">
<% end_if %>
<% if $Message %>
	<div id="app">
		<div role="alert" class="el-notification right" style="top: 129px; z-index: 2083;" v-if="show">
			<i class="el-notification__icon el-icon-success"></i>
			<div class="el-notification__group is-with-icon">
				<p class="el-notification__title">$Message</p>
				<a v-on:click="show = false" class="el-notification__closeBtn el-icon-close"></a>
			</div>
		</div>
	</div>
<% else %>
		<p id="{$FormName}_error" class="message $MessageType" style="display: none"></p>
<% end_if %>

<fieldset>
		<% if $Legend %><legend>$Legend</legend><% end_if %>

		<div id="ProfilFormApp">
			<div class="source">
				<div class="el-tabs el-tabs--top el-tabs--border-card">
					<div class="el-tabs__header is-top">
						<div class="el-tabs__nav-wrap is-top">
							<div class="el-tabs__nav-scroll">
							<%-- TABS --%>
								<div role="tablist" class="el-tabs__nav" style="transform: translateX(0px);">
									<div class="el-tabs__item is-top" v-on:click="clickTab0" v-bind:class="{ active: tab0IsActive }">
										Allgemein
									</div>
									<div class="el-tabs__item is-top" v-on:click="clickTab1" v-bind:class="{ active: tab1IsActive }">	
										Tanzprofil
										<% with $CurrentUser %>
											<% if $profilIsOutdated %>
												<div class="badge" title="Profil veraltet!"><i class="fa fa-exclamation"></i></div>
											<% end_if %>
										<% end_with %>
									</div>
									<div class="el-tabs__item is-top" v-on:click="clickTab2" v-bind:class="{ active: tab2IsActive }">	
										Aktuelle Turniere
									</div>
									<div class="el-tabs__item is-top" v-on:click="clickTab3" v-bind:class="{ active: tab3IsActive }">
										Vergangene Turniere
										<div class="badge">
											<% with $CurrentUser %>
												$numberOfIncompleteTournaments
											<% end_with %>
										</div>
									</div>
									<% with $CurrentUser %>
										<% if $isInCommittee %>
											<div class="el-tabs__item is-top" v-on:click="clickTab4" v-bind:class="{ active: tab4IsActive }">
												Vorstand
											</div>
										<% end_if %>
									<% end_with %>
								</div>
							</div>
						</div>
					</div>
					<div class="el-tabs__content">
						<%-- Allgemeine Daten --%>
						<section class="el-tab-pane" v-bind:class="{ active: tab0IsActive }" v-cloak>
							<div class="profil-group">
								<div class="profil-item">
									<label>Vorname:</label>
									$Fields.dataFieldByName(FirstName)
								</div>
								<div class="profil-item">
									<label>Nachname:</label>
									$Fields.dataFieldByName(Surname)
								</div>
							</div>
							<div class="profil-group">
								<div class="profil-item">
									<label>Email:</label>
									$Fields.dataFieldByName(Email)
								</div>
								<div class="profil-item">
									<label>Password:</label>
									<a href="Security/lostpassword" class="button button-pill">Passwort ändern</a>
								</div>
							</div>
							<div class="profil-group">
								<div class="profil-item">
									<a class="button button-pill" href="profil-edit/mailLink">
										<i class="fa fa-envelope"></i>&nbsp;&nbsp;Problem melden
									</a>
								</div>
							</div>
						</section>
						<%-- Tanzprofil --%>
						<section class="el-tab-pane" v-bind:class="{ active: tab1IsActive }" v-cloak>
							<div class="profil-group">
								<div class="profil-item">
									<label>Profilbild:</label>
									<% with $CurrentUser %>
										<!-- TODO: interactjs.io oder https://konvajs.github.io/docs/drag_and_drop/Drag_an_Image.html-->
										<div class="round-image small" style="border: 1px solid #ccc">
											<% if $profilImage %>
												<div class="image-wrapper" id="profilImage" <% if $profilImageX %>style="top: {$profilImageY}px; left: {$profilImageX}px;"<% end_if %>>
													$profilImage
												</div>
											<% end_if %>
										</div>
									<% end_with %>
									$Fields.dataFieldByName(profilImage)
								</div>
								<div class="profil-item">
									<label>Tanzpaarbild:</label>
									<% with $CurrentUser %>
										<% loop $danceProfil %>
											<div class="round-image small" style="border: 1px solid #ccc">
												<% if $danceProfilImage %>
													<div class="image-wrapper" id="profilImage" <% if $danceProfilImageX %>style="top: {$danceProfilImageY}px; left: {$danceProfilImageX}px;"<% end_if %>>
														$danceProfilImage
													</div>
												<% end_if %>
											</div>
										<% end_loop %>
									<% end_with %>
									$Fields.dataFieldByName(danceProfilImage)
								</div>
							</div>
							$Fields.dataFieldByName(danceProfilImageX)
							$Fields.dataFieldByName(danceProfilImageY)

							<div class="profil-group">
								<div class="profil-item">
									<label>Hobbies:</label>
									$Fields.dataFieldByName(hobbies)
								</div>
								<div class="profil-item">
									<label>Lieblingstänze:</label>
									$Fields.dataFieldByName(favDances)
								</div>
							</div>

							<div class="profil-group">
								<div class="profil-item">
									<label>Tanzpartner:</label>
									$Fields.dataFieldByName(dancePartnerID)
								</div>
							</div>

							<div class="profil-group">
								<div class="profil-item">
									<label>tanze seit:</label>
									$Fields.dataFieldByName(danceSince)
								</div>
								<div class="profil-item">
									<label>tanzen zusammen seit:</label>
									$Fields.dataFieldByName(danceTogetherSince)
								</div>
							</div>

							<div class="profil-group">
								<div class="profil-item">
									<label>Startgruppe</label>
									$Fields.dataFieldByName(danceGroup)
								</div>
								<div class="profil-item">
									<label>Klasse:</label>
									$Fields.dataFieldByName(danceClass)
								</div>
							</div>

							<div class="profil-group">
								<div class="profil-item">
									<label>Erfolge:</label>
									$Fields.dataFieldByName(successes)
								</div>
							</div>

							<div class="profil-group">
								<div class="profil-item">
									<label>Ein paar kurze Worte:</label>
									$Fields.dataFieldByName(description)
								</div>
							</div>
						</section>
						<%-- Aktuelle Turniere --%>
						<section class="el-tab-pane" v-bind:class="{ active: tab2IsActive }" v-cloak>
							<div class="tournaments">
								<h2>Turniere</h2>
								<div class="profil-group">
									<% with $CurrentUser %>
										<div class="profil-item striped">
											<section class="col-md-12">
												<% loop $Tournaments.Filter('Status:Not', 'Turnier löschen') %>
													<% if not $isOld %>
														<div class="item row col-md-12">
															<div class="col-md-2">$Datum.Nice</div>
															<div class="col-md-2">$Uhrzeit</div>
															<div class="col-md-3">$Ausrichter</div>
															<div class="col-md-2">$Startgruppe $Klasse $Type</div>
															<div class="col-md-2">$Status</div>
															<div class="col-md-1">
																<a href="edit-page?id=$ID"><i class="fa fa-trash-alt"></i></a>
															</div>
														</div>
													<% end_if %>
												<% end_loop %>
											</section>
										</div>
										
									<% end_with %>
								</div>
							</div>
						</section>
						<%-- Vergangene Turniere --%>
						<section class="el-tab-pane" v-bind:class="{ active: tab3IsActive }" v-cloak>
							<div class="tournaments">
								<h2>Turniere</h2>
								<div class="profil-group">
									<% with $CurrentUser %>
										<div class="profil-item striped">
											<section class="col-md-12">
												<% loop Tournaments.Sort(Datum, DESC) %>
													<% if $isOld %>
														<div class="item row col-md-12">
															<div class="col-md-2">$Datum.Nice</div>
															<div class="col-md-3">$Ausrichter</div>
															<div class="col-md-3">$Startgruppe $Klasse $Type</div>
															<div class="col-md-3">$Platzierung von $Gesamtplatzierungen</div>
															<div class="col-md-1">
																<a href="edit-page?id=$ID"><i class="fa fa-edit"></i></a>
																<% if $Platzierung %><% else %>
																	<div class="badge"><i class="fa fa-exclamation"></i></div>
																<% end_if %>
															</div>
														</div>
													<% end_if %>
												<% end_loop %>
											</section>
										</div>

									<% end_with %>
								</div>
							</div>
						</section>
						<%-- Vorstand --%>
						<section class="el-tab-pane" v-bind:class="{ active: tab4IsActive }" v-cloak>
							<h2>Vorstand:</h2>
							<div class="profil-group">
								<div class="profil-item">
									<label>Stelle:</label>
									$Fields.dataFieldByName(committeePosition)
								</div>
							</div>
							<div class="profil-group">
								<div class="profil-item">
									<label>E-Mail im Vorstand:</label>
									$Fields.dataFieldByName(committeeEmail)
								</div>
							</div>
							<div class="profil-group">
								<div class="profil-item">
									<label>Beschreibung Vorstand:</label>
									$Fields.dataFieldByName(committeeDescription)
								</div>
							</div>
						</section>
					</div>
				</div>
			</div>
		</div>

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



