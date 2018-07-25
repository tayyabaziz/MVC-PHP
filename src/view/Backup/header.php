<!-- Navigation -->
<nav class="navbar navbar-expand-md navbar-light sticky-top border shadow">
  <div class="container">
	<a class="navbar-brand" href="">{{ title }}</a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
	  <span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarResponsive">
	  <ul class="navbar-nav ml-auto">
		<li class="nav-item {% if pagename  == 'main' %} active {% endif %}">
		  <a class="nav-link" href="./">
			Home
		  </a>
		</li>
	  </ul>
	</div>
  </div> <!--end container -->
</nav>