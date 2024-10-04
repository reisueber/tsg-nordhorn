<div class="controller">
	<a href="javascript: history.back()" class="button button-pill back">zurück</a>
</div>

<!-- Page Content -->
      <div class="row">

        <!-- Post Content Column -->
        <div class="col-lg-8">

          <!-- Date/Time -->
          <% if $Date || $City %>
			  <hr>
              <p><% if $City %>$City<% end_if %><% if $Date && $City %>, <% end_if %><% if $Date %>$Date.Nice<% end_if %></p>
			  <hr>
          <% end_if %>

          <!-- Preview Image TODO: Bugfix-->
            <% if $MainImage %>
                <!-- <div class="main-image">

                 <div class="image-wrapper" id="mainImageWrapper"
                      <% if $MainImageY %>style="top: {$MainImageY}px; left: {$MainImageX}px;"<% end_if %>>
                  
                        <img id="mainImage" src="$MainImage.Link" />
                  
                 </div>
                      
                </div>-->
            <% end_if %>

          <!-- Post Content -->
          $Content
          <hr>

          <!-- Comments Form 
          <div class="card my-4">
            <h2 class="card-header">Dein Kommentar:</h2>
            <div class="card-body">
              <form>
                <div class="form-group">
                  <textarea class="form-control" rows="3"></textarea>
                </div>
                <button type="submit" class="button button-primary button-pill">Kommentar senden</button>
              </form>
            </div>
          </div>-->

          <!-- Single Comment 
          <div class="media mb-4">
            <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
            <div class="media-body">
              <h5 class="mt-0">Commenter Name</h5>
              Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                <div class="row">
					<a href="#" class="button button-pill button-flat button-border-primary button-tiny"><i class="fa fa-reply"></i></a>
                </div>
            </div>
          </div>-->

          <!-- Comment with nested comments 
          <div class="media mb-4">
            <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
            <div class="media-body">
              <h5 class="mt-0">Commenter Name</h5>
              Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.

              <div class="media mt-4">
                <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
                <div class="media-body">
                  <h5 class="mt-0">Commenter Name</h5>
                  Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                </div>
              </div>

              <div class="media mt-4">
                <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
                <div class="media-body">
                  <h5 class="mt-0">Commenter Name</h5>
                  Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                </div>
              </div>

            </div>
          </div>-->

        </div>

        <!-- Sidebar Widgets Column -->
        <div class="col-lg-4 col-md-12">

      <% if $isAdmin %>
        <div class="card my-4">
           $EditForm
        </div>
      <% end_if %>

			<!-- Foto Widget -->
			<% if $Images %>
        <div class="card my-4">
  				<h2 class="card-header">Fotos</h2>
  				<div class="card-body row">
  					<% loop $Images %>
                <div class="col-lg-6 col-md-4 col-sm-4 galleryimage">
                    <img src="$Fill(200,200).Link" class="img-responsive" alt="$Title" />
                </div>
  					<% end_loop %>
  				</div>
  			</div>
      <% end_if %>

          <!-- Categories Widget -->
          <div class="card my-4">
            <h2 class="card-header">Pressartikel</h2>
            <div class="card-body">
              <div class="row yearsOfArticles">
                <div class="col-lg-6">
                  <ul class="list-unstyled mb-0">
                    <% loop $Menu(2).Reverse %>
						<% if $Odd %>
							<li>
                                <% if $LinkingMode == "section"  %>
									<a href="$Link" class="current">
										<i class="fa fa-caret-right"></i>
                                      $Title
									</a>
                                <% else %>
									<a href="$Link">$Title</a>
                                <% end_if %>
							</li>
						<% end_if %>
                    <% end_loop %>
                  </ul>
                </div>
                <div class="col-lg-6">
                  <ul class="list-unstyled mb-0">
                    <% loop $Menu(2).Reverse %>
                      <% if $Even %>
						  <li>
                            <% if $LinkingMode == "section"  %>
								<a href="$Link" class="current">
                                  <i class="md-icon dp48">keyboard_arrow_right</i>
                                  $Title
                                </a>
                            <% else %>
								<a href="$Link">$Title</a>
                            <% end_if %>
						  </li>
                      <% end_if %>
                    <% end_loop %>
                  </ul>
                </div>
              </div>
            </div>
          </div>

        </div>

      </div>
      <!-- /.row -->

    </div>
    <!-- /.container -->