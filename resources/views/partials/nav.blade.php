                    <div class="page-logo">
                        <a href="#" class="page-logo-link press-scale-down d-flex align-items-center position-relative" data-toggle="modal" data-target="#modal-shortcut">
                            <img src="{{asset('images/spc_logo_no_bg.png')}}" style="width:100px; height:auto;" alt="SPC" aria-roledescription="logo">
                            <span class="page-logo-text mr-1">SPC placeholder</span>
                            <span class="position-absolute text-white opacity-50 small pos-top pos-right mr-2 mt-n2"></span>
                            <i class="fal fa-angle-down d-inline-block ml-1 fs-lg color-primary-300"></i>
                        </a>
                    </div>
							
					<!-- BEGIN PRIMARY NAVIGATION -->					
                    <nav id="js-primary-nav" class="primary-nav" role="navigation">
                        <div class="nav-filter">
                            <div class="position-relative">
                                <input type="text" id="nav_filter_input" placeholder="Filter menu" class="form-control" tabindex="0">
                                <a href="#" onclick="return false;" class="btn-primary btn-search-close js-waves-off" data-action="toggle" data-class="list-filter-active" data-target=".page-sidebar">
                                    <i class="fal fa-chevron-up"></i>
                                </a>
                            </div>
                        </div>
                        <div class="info-card">
                            <img src="{{asset('images/spc_logo_no_bg.png')}}" class="profile-image rounded-circle" alt="SPC">
                            <div class="info-card-text">
                                <a href="#" class="d-flex align-items-center text-white">
                                    <span class="text-truncate text-truncate-sm d-inline-block">
                                        SPC Stardoc
                                    </span>
                                </a>
                                <span class="d-inline-block text-truncate text-truncate-sm">Skip Tilton, owner</span>
                            </div>
                            <!--<img src="img/card-backgrounds/cover-2-lg.png" class="cover" alt="cover">-->
                            <a href="#" onclick="return false;" class="pull-trigger-btn" data-action="toggle" data-class="list-filter-active" data-target=".page-sidebar" data-focus="nav_filter_input">
                                <i class="fal fa-angle-down"></i>
                            </a>
                        </div>
                        <ul id="js-nav-menu" class="nav-menu">
                            <!--<li class="active open"> This will show the dashboards submenu on page load-->
							<li>
                                <a href="#" title="Dashboards" data-filter-tags="theme settings">
                                    <i class="fal fa-info-circle"></i>
                                    <span class="nav-link-text" data-i18n="nav.application_intel">Dashboards</span>
                                </a>
                                <ul>
                                    <li>
                                        <a href="intel_analytics_dashboard.html" data-filter-tags="application intel analytics dashboard">
                                            <span class="nav-link-text" data-i18n="nav.application_intel_analytics_dashboard">IT Asset Management</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{route('gauges.index')}}" data-filter-tags="application intel marketing dashboard">
                                            <span class="nav-link-text" data-i18n="nav.application_intel_marketing_dashboard">Building - Gauges</span>
                                        </a>
                                    </li>
                                    <li class="active">
                                        <a href="{{route('buildings_volume.index')}}" data-filter-tags="application intel introduction">
                                            <span class="nav-link-text" data-i18n="nav.application_intel_introduction">Building - Volume</span>
                                        </a>
                                    </li>
									<li>
                                        <a href="{{route('buildings_cost.index')}}" data-filter-tags="application intel privacy">
                                            <span class="nav-link-text" data-i18n="nav.application_intel_privacy">Building - Costs</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{route('departments_gauges.index')}}" data-filter-tags="application intel privacy">
                                            <span class="nav-link-text" data-i18n="nav.application_intel_privacy">Department - Gauges</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{route('departments_volume.index')}}" data-filter-tags="application intel build notes">
                                            <span class="nav-link-text" data-i18n="nav.application_intel_build_notes">Department - Volume</span>
                                            
                                        </a>
                                    </li>
									<li>
                                        <a href="{{route('departments_cost.index')}}" data-filter-tags="application intel privacy">
                                            <span class="nav-link-text" data-i18n="nav.application_intel_privacy">Department - Costs</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="intel_build_notes.html" data-filter-tags="application intel build notes">
                                            <span class="nav-link-text" data-i18n="nav.application_intel_build_notes">Charts</span>
                                            
                                        </a>
                                    </li>
                                </ul><!--end dashboards nav submenu-->
                            </li><!--end dashboards nav-->
                            <li>
                                <a href="#" title="Maps" data-filter-tags="theme settings">
                                    <i class="fal fa-cog"></i>
                                    <span class="nav-link-text" data-i18n="nav.theme_settings">Maps</span>
                                </a>
                                <ul>
                                    <li>
                                        <a href="#" data-filter-tags="theme settings how it works">
                                            <span class="nav-link-text" data-i18n="nav.theme_settings_how_it_works">Clients</span>
                                        </a>
										<ul>
											<li>
												<a href="settings_how_it_works.html" data-filter-tags="theme settings how it works">
													<span class="nav-link-text" data-i18n="nav.theme_settings_how_it_works">All Clients</span>
												</a>
											</li>
											<li>
												<a href="settings_layout_options.html" data-filter-tags="theme settings layout options">
													<span class="nav-link-text" data-i18n="nav.theme_settings_layout_options">LENP</span>
												</a>
											</li>
											<li>
												<a href="settings_skin_options.html" data-filter-tags="theme settings skin options">
													<span class="nav-link-text" data-i18n="nav.theme_settings_skin_options">No LENP</span>
												</a>
											</li>                                    
										</ul><!--end clients nav submenu-->									
										
                                    </li><!--end clients nav-->
                                    <li>
                                        <a href="#" data-filter-tags="theme settings layout options">
                                            <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options">Prospects</span>
                                        </a>
										<ul>
											<li>
												<a href="settings_how_it_works.html" data-filter-tags="theme settings how it works">
													<span class="nav-link-text" data-i18n="nav.theme_settings_how_it_works">All Prospects</span>
												</a>
											</li>
											<li>
												<a href="settings_layout_options.html" data-filter-tags="theme settings layout options">
													<span class="nav-link-text" data-i18n="nav.theme_settings_layout_options">Client &amp; Prospects</span>
												</a>
											</li>
											<li>
												<a href="settings_skin_options.html" data-filter-tags="theme settings skin options">
													<span class="nav-link-text" data-i18n="nav.theme_settings_skin_options">SuperSchool Prospects</span>
												</a>
											</li>                                    
										</ul><!--end prospects nav submenu-->
                                    </li><!--end prospects nav-->
                                    <li>
                                        <a href="settings_skin_options.html" data-filter-tags="theme settings skin options">
                                            <span class="nav-link-text" data-i18n="nav.theme_settings_skin_options">Vendors</span>
                                        </a>
                                    </li>                                    
                                </ul>
                            </li><!--end maps-->
							
							<li>
                                <a href="#" title="Floor Plans" data-filter-tags="theme settings">
                                    <i class="fal fa-cog"></i>
                                    <span class="nav-link-text" data-i18n="nav.theme_settings">Floor Plans</span>
                                </a>
								<ul>
									<li>
                           <a href="{{route('fpfloorpadm.index')}}" data-filter-tags="floorplans admin">
											<span class="nav-link-text" data-i18n="nav.floorplans_admin">Floorplans Admin</span>
										</a>
									</li>
									<li>
										<a href="settings_layout_options.html" data-filter-tags="theme settings layout options">
											<span class="nav-link-text" data-i18n="nav.theme_settings_layout_options">Construction Site</span>
										</a>
									</li>
									<li>
										<a href="settings_skin_options.html" data-filter-tags="theme settings skin options">
											<span class="nav-link-text" data-i18n="nav.theme_settings_skin_options">Demo Present</span>
										</a>
									</li>
									<li>
										<a href="settings_skin_options.html" data-filter-tags="theme settings skin options">
											<span class="nav-link-text" data-i18n="nav.theme_settings_skin_options">Demo Proposed</span>
										</a>
									</li>                                    
								</ul><!--end floorplans nav submenu-->
							</li><!--end floorplans nav-->
							
							<li>
								<a href="" data-filter-tags="theme settings skin options">
									<i class="fal fa-cog"></i>
									<span class="nav-link-text" data-i18n="nav.theme_settings_skin_options">Reports</span>
								</a>
							</li>
							
							<li>
								<a href="{{route('spc_users.index')}}" title="STARDoc Users" data-filter-tags="theme settings skin options">
									<i class="fal fa-cog"></i>
									<span class="nav-link-text" data-i18n="nav.theme_settings_skin_options">STARDoc Users</span>
								</a>
							</li>
							<li>
								<a href="" data-filter-tags="theme settings skin options"> <!--{{route('password.request')}}-->
									<i class="fal fa-cog"></i>
									<span class="nav-link-text" data-i18n="nav.theme_settings_skin_options">Reset Password</span>
								</a>
							</li>							
							
							<li>
                                <a href="#" title="Admin" data-filter-tags="theme settings">
                                    <i class="fal fa-cog"></i>
                                    <span class="nav-link-text" data-i18n="nav.theme_settings">Admin</span>
                                </a>
								<ul>
									<!--<li>
										<a href="#" data-filter-tags="theme settings how it works">
											<span class="nav-link-text" data-i18n="nav.theme_settings_how_it_works">Organization Data</span>
										</a>
										<ul>-->
											<li>
												<a href="{{route('organizations.index')}}" data-filter-tags="theme settings how it works">
													<span class="nav-link-text" data-i18n="nav.theme_settings_how_it_works">Organizations</span>
												</a>
											</li>
											<li>
												<a href="{{route('org_contacts.index')}}" data-filter-tags="theme settings layout options">
												<i class="fal"></i>
													<span class="nav-link-text" data-i18n="nav.theme_settings_layout_options">Contacts</span>
												</a>
											</li>
											<li>
												<a href="{{route('org_types.index')}}" data-filter-tags="theme settings how it works">
													<span class="nav-link-text" data-i18n="nav.theme_settings_how_it_works">Org Types</span>
												</a>
											</li>
											<li>
												<a href="settings_how_it_works.html" data-filter-tags="theme settings how it works">
													<span class="nav-link-text" data-i18n="nav.theme_settings_how_it_works">Service Rates By Org</span>
												</a>
											</li>
										<!--</ul>
									</li>-->
									<li>
										<a href="#" data-filter-tags="theme settings layout options">
										<i class="fal"></i>
											<span class="nav-link-text" data-i18n="nav.theme_settings_layout_options">Machines Data</span>
										</a>
										<ul>
											<li>
												<a href="{{route('buildings.index')}}" data-filter-tags="theme settings how it works">
													<span class="nav-link-text" data-i18n="nav.theme_settings_how_it_works">Buildings</span>
												</a>
											</li>
											<li>
												<a href="{{route('departments.index')}}" data-filter-tags="theme settings layout options">
												<i class="fal"></i>
													<span class="nav-link-text" data-i18n="nav.theme_settings_layout_options">Departments</span>
												</a>
											</li>
											<li>
												<a href="{{route('floorplans.index')}}" data-filter-tags="theme settings how it works">
													<span class="nav-link-text" data-i18n="nav.theme_settings_how_it_works">Floorplans</span>
												</a>
											</li>
											<li>
												<a href="{{route('floorplan_machines.index')}}" data-filter-tags="">
												<i class="fal"></i>
													<span class="nav-link-text" data-i18n="nav.theme_settings_layout_options">Floorplan Machines</span>
												</a>
											</li>
											<li>
												<a href="{{ route('machine_specs.index') }}" data-filter-tags="theme settings how it works">
													<span class="nav-link-text" data-i18n="nav.theme_settings_how_it_works">Machine Specs</span>
												</a>
											</li>
											<li>
												<a href="{{ route('machine_types.index') }}" data-filter-tags="theme settings layout options">
												<i class="fal"></i>
													<span class="nav-link-text" data-i18n="nav.theme_settings_layout_options">Machine Types</span>
												</a>
											</li>
											<li>
												<a href="{{ route('machine_statuses.index') }}" data-filter-tags="theme settings how it works">
													<span class="nav-link-text" data-i18n="nav.theme_settings_how_it_works">Machine Status</span>
												</a>
											</li>
											<li>
												<a href="{{ route('meters.index') }}" data-filter-tags="theme settings layout options">
												<i class="fal"></i>
													<span class="nav-link-text" data-i18n="nav.theme_settings_layout_options">Meters</span>
												</a>
											</li>
										</ul>							
										
										
										
									</li>
									<li>
										<a href="{{ route('spc_users.index') }}" data-filter-tags="theme settings skin options">
											<span class="nav-link-text" data-i18n="nav.theme_settings_skin_options">Users</span>
										</a>
									</li>
									
									<li>
										<a href="settings_layout_options.html" data-filter-tags="theme settings layout options">
											<span class="nav-link-text" data-i18n="nav.theme_settings_layout_options">Historical Volume</span>
										</a>
									</li>
									<li>
										<a href="settings_skin_options.html" data-filter-tags="theme settings skin options">
											<span class="nav-link-text" data-i18n="nav.theme_settings_skin_options">System Values</span>
										</a>
									</li>
									<li>
										<a href="settings_skin_options.html" data-filter-tags="theme settings skin options">
											<span class="nav-link-text" data-i18n="nav.theme_settings_skin_options">Non-Reporting Alerts List</span>
										</a>
									</li>                                     
								</ul><!--end admin nav submenu-->
							</li><!--end admin nav-->
						</ul><!--end nav menu-->
						
						<div class="filter-message js-filter-message bg-success-600"></div>
					</nav>
					<!-- END PRIMARY NAVIGATION -->
                    
					<!-- NAV PANE FOOTER -->
                    <div class="nav-footer shadow-top">
                        <a href="#" onclick="return false;" data-action="toggle" data-class="nav-function-minify" class="hidden-md-down">
                            <i class="ni ni-chevron-right"></i>
                            <i class="ni ni-chevron-right"></i>
                        </a>
                        <ul class="list-table m-auto nav-footer-buttons">
                            <li>
                                <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Chat logs">
                                    <i class="fal fa-comments"></i>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Support Chat">
                                    <i class="fal fa-life-ring"></i>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Make a call">
                                    <i class="fal fa-phone"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
					<!-- END NAV PANE FOOTER -->
					
				