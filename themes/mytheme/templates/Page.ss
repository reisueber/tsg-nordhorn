<!doctype html>
<html lang="$ContentLocale">
	<head>
		<% base_tag %>
		<title><% if $MetaTitle %>$MetaTitle<% else %>$Title<% end_if %> &raquo; $SiteConfig.Title</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		$MetaTags(false)

		<% require themedCSS('reset') %>
		<% require themedCSS('typography') %>
		<% require themedCSS('form') %>
		<% require themedCSS('layout') %>

		<link href="https://fonts.googleapis.com/css?family=Roboto|Work+Sans" rel="stylesheet">
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link rel="shortcut icon" href="themes/mytheme/images/favicon.ico" />
	</head>

	<body class="$ClassName $Title">

		<% include Navigation %>

		<main role="main">

			<div class="container">
				<% if $Title != "Startseite" %><header><h1>$Title</h1></header><% end_if %>
				$Layout
			</div>
		</main>

		<% include Footer %>

	</body>
</html>