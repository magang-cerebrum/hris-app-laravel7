@extends('layout/templateAdmin')
@section('title', 'Gaji')
@section('content')

                    
	<div class="row">
		<div class="col-lg-7">

			<!--Network Line Chart-->
			<!--===================================================-->
			<div id="demo-panel-network" class="panel">
				<!-- <div class="panel-heading">
					<div class="panel-control">
						<button id="demo-panel-network-refresh" class="btn btn-default btn-active-primary" data-toggle="panel-overlay" data-target="#demo-panel-network"><i class="demo-psi-repeat-2"></i></button>
						<div class="dropdown">
							<button class="dropdown-toggle btn btn-default btn-active-primary" data-toggle="dropdown" aria-expanded="false"><i class="demo-psi-dot-vertical"></i></button>
							<ul class="dropdown-menu dropdown-menu-right">
								<li><a href="#">Action</a></li>
								<li><a href="#">Another action</a></li>
								<li><a href="#">Something else here</a></li>
								<li class="divider"></li>
								<li><a href="#">Separated link</a></li>
							</ul>
						</div>
					</div>
					<h3 class="panel-title">Network</h3>
				</div> -->


				<!--chart placeholder-->
				<div class="pad-all">
					<div id="demo-chart-network" style="height: 255px"></div>
				</div>


				<!--Chart information-->
				<!-- <div class="panel-body">

					<div class="row">
						<div class="col-lg-8">
							<p class="text-semibold text-uppercase text-main">CPU Temperature</p>
							<div class="row">
								<div class="col-xs-5">
									<div class="media">
										<div class="media-left">
											<span class="text-3x text-thin text-main">43.7</span>
										</div>
										<div class="media-body">
											<p class="mar-no">°C</p>
										</div>
									</div>
								</div>
								<div class="col-xs-7 text-sm">
									<p>
										<span>Min Values</span>
										<span class="pad-lft text-semibold">
										<span class="text-lg">27°</span>
										<span class="labellabel-success mar-lft">
											<i class="pci-caret-down text-success"></i>
											<smal>- 20</smal>
										</span>
										</span>
									</p>
									<p>
										<span>Max Values</span>
										<span class="pad-lft text-semibold">
										<span class="text-lg">69°</span>
										<span class="labellabel-danger mar-lft">
											<i class="pci-caret-up text-danger"></i>
											<smal>+ 57</smal>
										</span>
										</span>
									</p>
								</div>
							</div>

							<hr>

							<div class="pad-rgt">
								<p class="text-semibold text-uppercase text-main">Today Tips</p>
								<p class="text-muted mar-top">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt.</p>
							</div>
						</div>

						<div class="col-lg-4">
							<p class="text-uppercase text-semibold text-main">Bandwidth Usage</p>
							<ul class="list-unstyled">
								<li>
									<div class="media pad-btm">
										<div class="media-left">
											<span class="text-2x text-thin text-main">754.9</span>
										</div>
										<div class="media-body">
											<p class="mar-no">Mbps</p>
										</div>
									</div>
								</li>
								<li class="pad-btm">
									<div class="clearfix">
										<p class="pull-left mar-no">Income</p>
										<p class="pull-right mar-no">70%</p>
									</div>
									<div class="progress progress-sm">
										<div class="progress-bar progress-bar-info" style="width: 70%;">
											<span class="sr-only">70% Complete</span>
										</div>
									</div>
								</li>
								<li>
									<div class="clearfix">
										<p class="pull-left mar-no">Outcome</p>
										<p class="pull-right mar-no">10%</p>
									</div>
									<div class="progress progress-sm">
										<div class="progress-bar progress-bar-primary" style="width: 10%;">
											<span class="sr-only">10% Complete</span>
										</div>
									</div>
								</li>
							</ul>
						</div>
					</div>
				</div> -->


			</div>
			<!--===================================================-->
			<!--End network line chart-->

		</div>
		<div class="col-lg-5">
			<div class="row">
				<div class="col-sm-6 col-lg-6">

					<!--Sparkline Area Chart-->
					<div class="panel panel-success panel-colorful">
						<div class="pad-all">
							<p class="text-lg text-semibold"><i class="demo-pli-data-storage icon-fw"></i> HDD Usage</p>
							<p class="mar-no">
								<span class="pull-right text-bold">132Gb</span> Free Space
							</p>
							<p class="mar-no">
								<span class="pull-right text-bold">1,45Gb</span> Used space
							</p>
						</div>
						<div class="pad-top text-center">
							<!--Placeholder-->
							<div id="demo-sparkline-area" class="sparklines-full-content"></div>
						</div>
					</div>
				</div>
				<div class="col-sm-6 col-lg-6">

					<!--Sparkline Line Chart-->
					<div class="panel panel-info panel-colorful">
						<div class="pad-all">
							<p class="text-lg text-semibold">Earning</p>
							<p class="mar-no">
								<span class="pull-right text-bold">$764</span> Today
							</p>
							<p class="mar-no">
								<span class="pull-right text-bold">$1,332</span> Last 7 Day
							</p>
						</div>
						<div class="pad-top text-center">

							<!--Placeholder-->
							<div id="demo-sparkline-line" class="sparklines-full-content"></div>

						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6 col-lg-6">

					<!--Sparkline bar chart -->
					<div class="panel panel-purple panel-colorful">
						<div class="pad-all">
							<p class="text-lg text-semibold"><i class="demo-pli-basket-coins icon-fw"></i> Sales</p>
							<p class="mar-no">
								<span class="pull-right text-bold">$764</span> Today
							</p>
							<p class="mar-no">
								<span class="pull-right text-bold">$1,332</span> Last 7 Day
							</p>
						</div>
						<div class="text-center">

							<!--Placeholder-->
							<div id="demo-sparkline-bar" class="box-inline"></div>

						</div>
					</div>
				</div>
				<div class="col-sm-6 col-lg-6">

					<!--Sparkline pie chart -->
					<div class="panel panel-warning panel-colorful">
						<div class="pad-all">
							<p class="text-lg text-semibold">Task Progress</p>
							<p class="mar-no">
								<span class="pull-right text-bold">34</span> Completed
							</p>
							<p class="mar-no">
								<span class="pull-right text-bold">79</span> Total
							</p>
						</div>
						<div class="pad-all">
							<div class="pad-btm">
								<div class="progress progress-sm">
									<div style="width: 45%;" class="progress-bar progress-bar-light">
										<span class="sr-only">45%</span>
									</div>
								</div>
							</div>
							<div class="pad-btm">
								<div class="progress progress-sm">
									<div style="width: 89%;" class="progress-bar progress-bar-light">
										<span class="sr-only">89%</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>


			<!--Extra Small Weather Widget-->
			<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
			<!-- <div class="panel">
				<div class="panel-body text-center clearfix">
					<div class="col-sm-4 pad-top">
						<div class="text-lg">
							<p class="text-5x text-thin text-main">95</p>
						</div>
						<p class="text-sm text-bold text-uppercase">New Friends</p>
					</div>
					<div class="col-sm-8">
						<button class="btn btn-pink mar-ver">View Details</button>
						<p class="text-xs">Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</p>
						<ul class="list-unstyled text-center bord-top pad-top mar-no row">
							<li class="col-xs-4">
								<span class="text-lg text-semibold text-main">1,345</span>
								<p class="text-sm text-muted mar-no">Following</p>
							</li>
							<li class="col-xs-4">
								<span class="text-lg text-semibold text-main">23K</span>
								<p class="text-sm text-muted mar-no">Followers</p>
							</li>
							<li class="col-xs-4">
								<span class="text-lg text-semibold text-main">278</span>
								<p class="text-sm text-muted mar-no">Post</p>
							</li>
						</ul>
					</div>
				</div>
			</div> -->

			<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
			<!--End Extra Small Weather Widget-->


		</div>
	</div>

	

	


	

@endsection