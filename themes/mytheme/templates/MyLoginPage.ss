<!doctype html>
<html lang="$ContentLocale">
<head>
	<% base_tag %>
	<title><% if $MetaTitle %>$MetaTitle<% else %>$Title<% end_if %> &raquo; $SiteConfig.Title</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	$MetaTags(false)
	
	<% require themedCSS('layout') %>

	<link href="https://fonts.googleapis.com/css?family=Roboto|Work+Sans" rel="stylesheet">
	<link rel="shortcut icon" href="themes/simple/images/favicon.ico" />
</head>

<body>

	<div class="wrapper">
		<form class="form-signin">
			<h2 class="form-signin-heading">Please login</h2>
			<input type="text" class="form-control" name="username" placeholder="Email Address" required="" autofocus="" />
			<input type="password" class="form-control" name="password" placeholder="Password" required=""/>
			<label class="checkbox">
				<input type="checkbox" value="remember-me" id="rememberMe" name="rememberMe"> Remember me
			</label>
			<button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
		</form>
	</div>

</body>
</html>