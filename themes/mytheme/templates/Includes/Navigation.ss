<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-blue">

	<a class="navbar-brand" href="#">TSG Nordhorn</a>
	<button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>

	<div class="collapse navbar-collapse" id="navbarsExampleDefault">
		<ul class="navbar-nav mr-auto">

			<% loop $Menu(1) %>
				<% if $Children && $Title != "Presse" %>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle $LinkingMode" href="$Link" id="dropdown$Pos" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">$MenuTitle.XML</a>
						<div class="dropdown-menu" aria-labelledby="dropdown$Pos">
							<% loop $Children %>
								<a class="dropdown-item" href="$Link">$MenuTitle.XML</a>
							<% end_loop %>
						</div>
					</li>
				<% else %>
					<li class="nav-item">
						<a class="nav-link $LinkingMode" href="$Link" title="$Title.XML">$MenuTitle.XML</a>
					</li>
				<% end_if %>

			<% end_loop %>

		</ul>
		<form class="searchfield form-inline my-2 my-lg-0">
			<input class="form-control form-control-sm mr-sm-2" type="text" placeholder="Search" aria-label="Search">
			<button class="button button-pill button-border button-small" type="submit"><i class="fa fa-search"></i></button>
		</form>
		<% if $CurrentUser %>
			<a href="Security/logout" class="button button-pill button-border-primary"><i class="fa fa-sign-out"></i> <span>Logout</span></a>
			<!--<a href="/profil-edit" class="button button-pill button-border-primary">
				<i class="fa fa-user"></i> Profil
			</a>-->
		<% else %>
			<a href="Security/login" class="login button button-pill button-border-primary"><i class="fa fa-key"></i> Login</a>
		<% end_if %>

	</div>
</nav>
<div class="red-line"></div>