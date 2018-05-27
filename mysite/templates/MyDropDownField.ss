

<span class="button-dropdown" data-buttons="dropdown">
	  <a href="#" class="button button-rounded" id="dropdown-$Title">
		  <% if $Title.exists %>$Title.XML<% else %> <% end_if %> <i class="fa fa-caret-down"></i>
	  </a>

	  <ul class="button-dropdown-menu-below">
		<% loop $Options %>
		  <li data-fieldname="$Top.Title"><a href="#"><% if $Title.exists %>$Title.XML<% else %>&nbsp;<% end_if %></a></li>
		<% end_loop %>
	  </ul>

	 <input id="field-$Title" name="$Title" value="" class="hidden">

</span>

<% require javascript("themes/mytheme/javascript/myDropDownField.js") %>
