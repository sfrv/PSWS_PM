
<!DOCTYPE html>
<html class="no-js css-menubar" lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="bootstrap material admin template">
    <meta name="author" content="">
    
    <title>CRUED - SEDES</title>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="apple-touch-icon" href="{{asset('base/assets/images/apple-touch-icon.png')}}">
    <link rel="shortcut icon" href="{{asset('images/iconoTaller.png')}}">
    
    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{asset('global/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('global/css/bootstrap-extend.min.css')}}">
    <link rel="stylesheet" href="{{asset('base/assets/css/site.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/my_css.css')}}">
    
    <!-- Plugins -->
    <link rel="stylesheet" href="{{asset('global/vendor/animsition/animsition.css')}}">
    <link rel="stylesheet" href="{{asset('global/vendor/asscrollable/asScrollable.css')}}">
    <link rel="stylesheet" href="{{asset('global/vendor/switchery/switchery.css')}}">
    <link rel="stylesheet" href="{{asset('global/vendor/intro-js/introjs.css')}}">
    <link rel="stylesheet" href="{{asset('global/vendor/slidepanel/slidePanel.css')}}">
    <link rel="stylesheet" href="{{asset('global/vendor/flag-icon-css/flag-icon.css')}}">
    <link rel="stylesheet" href="{{asset('global/vendor/waves/waves.css')}}">
    <link rel="stylesheet" href="{{asset('global/vendor/dropify/dropify.css')}}">
    <link rel="stylesheet" href="{{asset('global/vendor/blueimp-file-upload/jquery.fileupload.css')}}">
    
    <!-- Fonts -->
    <link rel="stylesheet" href="{{asset('global/vendor/toastr/toastr.css')}}">
    <link rel="stylesheet" href="{{asset('base/assets/examples/css/advanced/toastr.css')}}">
    <link rel="stylesheet" href="{{asset('global/fonts/material-design/material-design.min.css')}}">
    <link rel="stylesheet" href="{{asset('global/fonts/brand-icons/brand-icons.min.css')}}">
    <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>
    
    <!--[if lt IE 9]>
    <script src="../../../global/vendor/html5shiv/html5shiv.min.js"></script>
    <![endif]-->
    
    <!--[if lt IE 10]>
    <script src="../../../global/vendor/media-match/media.match.min.js"></script>
    <script src="../../../global/vendor/respond/respond.min.js"></script>
    <![endif]-->
    
    <!-- Scripts -->
    <script src="{{asset('global/vendor/breakpoints/breakpoints.js')}}"></script>
    <script>
      Breakpoints();
    </script>
  </head>
  <body class="animsition" id="mynav">
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->

    <nav class="site-navbar navbar navbar-default navbar-fixed-top navbar-mega" role="navigation">
    
      <div class="navbar-header">
        <button type="button" class="navbar-toggler hamburger hamburger-close navbar-toggler-left hided"
          data-toggle="menubar">
          <span class="sr-only">Toggle navigation</span>
          <span class="hamburger-bar"></span>
        </button>
        <button type="button" class="navbar-toggler collapsed" data-target="#site-navbar-collapse"
          data-toggle="collapse">
          <i class="icon md-more" aria-hidden="true"></i>
        </button>
        <div class="navbar-brand navbar-brand-center site-gridmenu-toggle" data-toggle="gridmenu">
          <img class="navbar-brand-logo" src="{{asset('base/assets/images/logo@2x.png')}}" title="Remark">
          <span class="navbar-brand-text hidden-xs-down"> CRUED - SEDES</span>
        </div>
        <button type="button" class="navbar-toggler collapsed" data-target="#site-navbar-search"
          data-toggle="collapse">
          <span class="sr-only">Toggle Search</span>
          <i class="icon md-search" aria-hidden="true"></i>
        </button>
      </div>
    
      <div class="navbar-container container-fluid">
        <!-- Navbar Collapse -->
        <div class="collapse navbar-collapse navbar-collapse-toolbar" id="site-navbar-collapse">
          <!-- Navbar Toolbar -->
          <ul class="nav navbar-toolbar">
            <li class="nav-item hidden-float" id="toggleMenubar">
              <a id="linkmn" class="nav-link" data-toggle="menubar" href="#" role="button">
                <i class="icon hamburger hamburger-arrow-left">
                  <span class="sr-only">Toggle menubar</span>
                  <span class="hamburger-bar"></span>
                </i>
              </a>
            </li>
            <li class="nav-item hidden-sm-down" id="toggleFullscreen">
              <a class="nav-link icon icon-fullscreen" data-toggle="fullscreen" href="#" role="button">
                <span class="sr-only">Toggle fullscreen</span>
              </a>
            </li>
            <li class="nav-item hidden-float">
              <a class="nav-link icon md-search" data-toggle="collapse" href="#" data-target="#site-navbar-search"
                role="button">
                <span class="sr-only">Toggle Search</span>
              </a>
            </li>
          </ul>
          <!-- End Navbar Toolbar -->
    
          <!-- Navbar Toolbar Right -->
          <ul class="nav navbar-toolbar navbar-right navbar-toolbar-right">
            
            <li class="nav-item dropdown">
              <a class="nav-link navbar-avatar" data-toggle="dropdown" href="#" aria-expanded="false"
                data-animation="scale-up" role="button">
                <span class="avatar avatar-online">
                  <img src="{{asset('images/iconoTaller.png')}}" alt="...">
                  <i></i>
                </span>
              </a>
              <div class="dropdown-menu" role="menu">
                <a class="dropdown-item" href="javascript:void(0)" role="menuitem"><i class="icon md-account" aria-hidden="true"></i> {{ Auth::user()->name }}</a>
                <a class="dropdown-item" href="javascript:void(0)" role="menuitem"><i class="icon md-card" aria-hidden="true"></i>CRUED - SEDES</a>
                <a class="dropdown-item" href="javascript:void(0)" role="menuitem"><i class="icon md-settings" aria-hidden="true"></i> {{ Auth::user()->tipo }}</a>
                <div class="dropdown-divider" role="presentation"></div>

                <a class="dropdown-item" href="{{ route('logout') }}" role="menuitem" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="icon md-power" aria-hidden="true"></i> Cerrar Sesion</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
              </div>
            </li>
            <li class="nav-item" id="toggleChat">
              <a class="nav-link" data-toggle="site-sidebar" href="javascript:void(0)" title="Chat"
                data-url="../site-sidebar.tpl">
                <i class="icon md-comment" aria-hidden="true"></i>
              </a>
            </li>
          </ul>
          <!-- End Navbar Toolbar Right -->
        </div>
        <!-- End Navbar Collapse -->
    
        <!-- Site Navbar Seach -->
        <div class="collapse navbar-search-overlap" id="site-navbar-search">
          <form role="search">
            <div class="form-group">
              <div class="input-search">
                <i class="input-search-icon md-search" aria-hidden="true"></i>
                <input type="text" class="form-control" name="site-search" placeholder="Search...">
                <button type="button" class="input-search-close icon md-close" data-target="#site-navbar-search"
                  data-toggle="collapse" aria-label="Close"></button>
              </div>
            </div>
          </form>
        </div>
        <!-- End Site Navbar Seach -->
      </div>
    </nav>    <div class="site-menubar">
      <div class="site-menubar-body">
        <div>
          <div>
            <ul class="site-menu" data-plugin="menu">
              <li class="site-menu-category">General</li>
              <li class="site-menu-item">
                <a class="animsition-link" href="{{url('dashboard')}}">
                        <i class="site-menu-icon md-view-dashboard" aria-hidden="true"></i>
                        <span class="site-menu-title">Dashboard</span>
                    </a>
              </li>
              <li class="site-menu-category">Elementos</li>
              <li class="site-menu-item has-sub">
                <!-- <a href="{{url('adm/centro')}}"> -->
                <a>
                    <i class="site-menu-icon md-balance" aria-hidden="true"></i>
                    <span class="site-menu-title">Centros Medicos</span>
                    <span class="site-menu-arrow"></span>
                </a>
                <ul class="site-menu-sub">
                  <li class="site-menu-item">
                    <a class="animsition-link" href="{{url('adm/centro')}}">
                      <span class="site-menu-title">Gest. Centros Medicos</span>
                    </a>
                  </li>
                  <li class="site-menu-item">
                    <a class="animsition-link" href="{{url('adm/especialidad')}}">
                      <span class="site-menu-title">Gest. Especialidades</span>
                    </a>
                  </li>
                  <li class="site-menu-item">
                    <a class="animsition-link" href="{{url('adm/medico')}}">
                      <span class="site-menu-title">Gest. Medicos</span>
                    </a>
                  </li>
                  <li class="site-menu-item">
                    <a class="animsition-link" href="{{url('adm/servicio')}}">
                      <span class="site-menu-title">Gest. Tipo Servicios</span>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="site-menu-item has-sub">
                <!-- <a href="{{url('adm/centro')}}"> -->
                <a>
                    <i class="site-menu-icon md-shield-security" aria-hidden="true"></i>
                    <span class="site-menu-title">Seguridad</span>
                    <span class="site-menu-arrow"></span>
                </a>
                <ul class="site-menu-sub">
                  <li class="site-menu-item">
                    <a class="animsition-link" href="{{url('adm/usuario')}}">
                      <span class="site-menu-title">Gest. Usuarios</span>
                    </a>
                  </li>
                  <li class="site-menu-item">
                    <a class="animsition-link" href="{{url('adm/servicio_metodo')}}">
                      <span class="site-menu-title">Gest. Previlegios</span>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="site-menu-item has-sub">
                <!-- <a href="{{url('adm/centro')}}"> -->
                <a>
                    <i class="site-menu-icon md-input-composite" aria-hidden="true"></i>
                    <span class="site-menu-title">Estructura y Distribucion</span>
                    <span class="site-menu-arrow"></span>
                </a>
                <ul class="site-menu-sub">
                  <li class="site-menu-item">
                    <a class="animsition-link" href="{{url('adm/red')}}">
                      <span class="site-menu-title">Gest. Redes</span>
                    </a>
                  </li>
                  <li class="site-menu-item">
                    <a class="animsition-link" href="{{url('adm/zona')}}">
                      <span class="site-menu-title">Gest. Zonas</span>
                    </a>
                  </li>
                  <li class="site-menu-item">
                    <a class="animsition-link" href="{{url('adm/nivel')}}">
                      <span class="site-menu-title">Gest. Niveles</span>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="site-menu-item has-sub">
                <!-- <a href="{{url('adm/centro')}}"> -->
                <a>
                    <i class="site-menu-icon md-swap-vertical" aria-hidden="true"></i>
                    <span class="site-menu-title">Servicios</span>
                    <span class="site-menu-arrow"></span>
                </a>
                <ul class="site-menu-sub">
                  <li class="site-menu-item">
                    <a class="animsition-link" href="{{url('adm/servicio_metodo')}}">
                      <span class="site-menu-title">Gest. Servicios</span>
                    </a>
                  </li>
                </ul>
              </li>
              <!-- <li class="site-menu-item has-sub">
                <a href="{{url('adm/nivel')}}">
                    <i class="site-menu-icon md-format-clear-all" aria-hidden="true"></i>
                    <span class="site-menu-title">Niveles</span>
                            <span class="site-menu-arrow"></span>
                </a>
              </li>
              <li class="site-menu-item has-sub">
                <a href="{{url('adm/zona')}}">
                    <i class="site-menu-icon md-plus-circle-o-duplicate" aria-hidden="true"></i>
                    <span class="site-menu-title">Zonas</span>
                            <span class="site-menu-arrow"></span>
                </a>
              </li>
              <li class="site-menu-item has-sub">
                <a href="{{url('adm/especialidad')}}">
                    <i class="site-menu-icon md-favorite-outline" aria-hidden="true"></i>
                    <span class="site-menu-title">Especialidades</span>
                            <span class="site-menu-arrow"></span>
                </a>
              </li>
              <li class="site-menu-item has-sub">
                <a href="{{url('adm/red')}}">
                    <i class="site-menu-icon md-group-work" aria-hidden="true"></i>
                    <span class="site-menu-title">Redes</span>
                            <span class="site-menu-arrow"></span>
                </a>
              </li>
              <li class="site-menu-item has-sub">
                <a href="{{url('adm/servicio')}}">
                    <i class="site-menu-icon md-receipt" aria-hidden="true"></i>
                    <span class="site-menu-title">Tipos Servicios</span>
                            <span class="site-menu-arrow"></span>
                </a>
              </li>
              <li class="site-menu-item has-sub">
                <a href="{{url('adm/medico')}}">
                    <i class="site-menu-icon md-accounts-add" aria-hidden="true"></i>
                    <span class="site-menu-title">Medicos</span>
                            <span class="site-menu-arrow"></span>
                </a>
              </li>
              <li class="site-menu-item has-sub">
                <a href="{{url('adm/usuario')}}">
                    <i class="site-menu-icon md-male-female" aria-hidden="true"></i>
                    <span class="site-menu-title">Usuarios</span>
                            <span class="site-menu-arrow"></span>
                </a>
              </li> -->
              <li class="site-menu-category">App</li>
              <li class="site-menu-item has-sub">
                <a href="javascript:void(0)">
                        <i class="site-menu-icon md-apps" aria-hidden="true"></i>
                        <span class="site-menu-title">Apps</span>
                                <span class="site-menu-arrow"></span>
                    </a>
                <ul class="site-menu-sub">
                  <li class="site-menu-item">
                    <a class="animsition-link" href="../apps/contacts/contacts.html">
                      <span class="site-menu-title">Contacts</span>
                    </a>
                  </li>
                  <li class="site-menu-item">
                    <a class="animsition-link" href="../apps/calendar/calendar.html">
                      <span class="site-menu-title">Calendar</span>
                    </a>
                  </li>
                  <li class="site-menu-item">
                    <a class="animsition-link" href="../apps/notebook/notebook.html">
                      <span class="site-menu-title">Notebook</span>
                    </a>
                  </li>
                  <li class="site-menu-item">
                    <a class="animsition-link" href="../apps/taskboard/taskboard.html">
                      <span class="site-menu-title">Taskboard</span>
                    </a>
                  </li>
                  <li class="site-menu-item has-sub">
                    <a href="javascript:void(0)">
                      <span class="site-menu-title">Documents</span>
                      <span class="site-menu-arrow"></span>
                    </a>
                    <ul class="site-menu-sub">
                      <li class="site-menu-item">
                        <a class="animsition-link" href="../apps/documents/articles.html">
                          <span class="site-menu-title">Articles</span>
                        </a>
                      </li>
                      <li class="site-menu-item">
                        <a class="animsition-link" href="../apps/documents/categories.html">
                          <span class="site-menu-title">Categories</span>
                        </a>
                      </li>
                      <li class="site-menu-item">
                        <a class="animsition-link" href="../apps/documents/article.html">
                          <span class="site-menu-title">Article</span>
                        </a>
                      </li>
                    </ul>
                  </li>
                  <li class="site-menu-item">
                    <a class="animsition-link" href="../apps/forum/forum.html">
                      <span class="site-menu-title">Forum</span>
                    </a>
                  </li>
                  <li class="site-menu-item">
                    <a class="animsition-link" href="../apps/message/message.html">
                      <span class="site-menu-title">Message</span>
                    </a>
                  </li>
                  <li class="site-menu-item">
                    <a class="animsition-link" href="../apps/projects/projects.html">
                      <span class="site-menu-title">Projects</span>
                    </a>
                  </li>
                  <li class="site-menu-item">
                    <a class="animsition-link" href="../apps/mailbox/mailbox.html">
                      <span class="site-menu-title">Mailbox</span>
                    </a>
                  </li>
                  <li class="site-menu-item">
                    <a class="animsition-link" href="../apps/media/overview.html">
                      <span class="site-menu-title">Media</span>
                    </a>
                  </li>
                  <li class="site-menu-item">
                    <a class="animsition-link" href="../apps/work/work.html">
                      <span class="site-menu-title">Work</span>
                    </a>
                  </li>
                  <li class="site-menu-item">
                    <a class="animsition-link" href="../apps/location/location.html">
                      <span class="site-menu-title">Location</span>
                    </a>
                  </li>
                  <li class="site-menu-item">
                    <a class="animsition-link" href="../apps/travel/travel.html">
                      <span class="site-menu-title">Travel</span>
                    </a>
                  </li>
                </ul>
              </li>
            </ul>     </div>
        </div>
      </div>
    
      </div>    <div class="site-gridmenu">
      <div>
        <div>
          <ul>
            <li>
              <a href="../apps/mailbox/mailbox.html">
                <i class="icon md-email"></i>
                <span>Mailbox</span>
              </a>
            </li>
            <li>
              <a href="../apps/calendar/calendar.html">
                <i class="icon md-calendar"></i>
                <span>Calendar</span>
              </a>
            </li>
            <li>
              <a href="../apps/contacts/contacts.html">
                <i class="icon md-account"></i>
                <span>Contacts</span>
              </a>
            </li>
            <li>
              <a href="../apps/media/overview.html">
                <i class="icon md-videocam"></i>
                <span>Media</span>
              </a>
            </li>
            <li>
              <a href="../apps/documents/categories.html">
                <i class="icon md-receipt"></i>
                <span>Documents</span>
              </a>
            </li>
            <li>
              <a href="../apps/projects/projects.html">
                <i class="icon md-image"></i>
                <span>Project</span>
              </a>
            </li>
            <li>
              <a href="../apps/forum/forum.html">
                <i class="icon md-comments"></i>
                <span>Forum</span>
              </a>
            </li>
            <li>
              <a href="../index.html">
                <i class="icon md-view-dashboard"></i>
                <span>Dashboard</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>

    <!-- Page -->
    <div class="page">
      <div class="page-content">
        
                <!--Contenido-->
                  @yield('contenido')
                <!--Fin Contenido-->
            
      </div>
    </div>
    <!-- End Page -->


    <!-- Footer -->
    <footer class="site-footer">
      <div class="site-footer-legal">© 2019 <a href="http://themeforest.net/item/remark-responsive-bootstrap-admin-template/11989202">CRUED - SEDES</a></div>
      <div class="site-footer-right">
        <i class="red-600 icon md-favorite"></i> <a href="https://themeforest.net/user/creation-studio">UAGRM</a>
      </div>
    </footer>
    <!-- Core  -->

    <script src="{{asset('global/vendor/babel-external-helpers/babel-external-helpers.js')}}"></script>
    <script src="{{asset('global/vendor/jquery/jquery.js')}}"></script>
    <script src="{{asset('global/vendor/popper-js/umd/popper.min.js')}}"></script>
    <script src="{{asset('global/vendor/bootstrap/bootstrap.js')}}"></script>
    <script src="{{asset('global/vendor/animsition/animsition.js')}}"></script>
    <script src="{{asset('global/vendor/mousewheel/jquery.mousewheel.js')}}"></script>
    <script src="{{asset('global/vendor/asscrollbar/jquery-asScrollbar.js')}}"></script>
    <script src="{{asset('global/vendor/asscrollable/jquery-asScrollable.js')}}"></script>
    <script src="{{asset('global/vendor/ashoverscroll/jquery-asHoverScroll.js')}}"></script>
    <script src="{{asset('global/vendor/waves/waves.js')}}"></script>
    
    <!-- Plugins -->
    <script src="{{asset('global/vendor/switchery/switchery.js')}}"></script>
    <script src="{{asset('global/vendor/intro-js/intro.js')}}"></script>
    <script src="{{asset('global/vendor/screenfull/screenfull.js')}}"></script>
    <script src="{{asset('global/vendor/slidepanel/jquery-slidePanel.js')}}"></script>
    
    <!-- Scripts -->
    <script src="{{asset('global/js/Component.js')}}"></script>
    <script src="{{asset('global/js/Plugin.js')}}"></script>
    <script src="{{asset('global/js/Base.js')}}"></script>
    <script src="{{asset('global/js/Config.js')}}"></script>
    
    <script src="{{asset('base/assets/js/Section/Menubar.js')}}"></script>
    <script src="{{asset('base/assets/js/Section/GridMenu.js')}}"></script>
    <script src="{{asset('base/assets/js/Section/Sidebar.js')}}"></script>
    <script src="{{asset('base/assets/js/Section/PageAside.js')}}"></script>
    <script src="{{asset('base/assets/js/Plugin/menu.js')}}"></script>
    
    <script src="{{asset('global/js/config/colors.js')}}"></script>
    <script src="{{asset('base/assets/js/config/tour.js')}}"></script>
    <script>Config.set('assets', "{{asset('base/assets')}}");</script>
    
    <!-- Page -->
    <script src="{{asset('base/assets/js/Site.js')}}"></script>
    <script src="{{asset('global/js/Plugin/asscrollable.js')}}"></script>
    <script src="{{asset('global/js/Plugin/slidepanel.js')}}"></script>
    <script src="{{asset('global/js/Plugin/switchery.js')}}"></script>
    <script src="{{asset('global/js/Plugin/toastr.js')}}"></script>
    <script src="{{asset('global/vendor/toastr/toastr.js')}}"></script>
    <script src="{{asset('global/js/Plugin/material.js')}}"></script>
    <script src="{{asset('global/js/Plugin/ladda.js')}}"></script>
    <script src="{{asset('global/js/Plugin/action-btn.js')}}"></script>
    @stack('scripts')
    
    <script>
      (function(document, window, $){
        'use strict';
    
        var Site = window.Site;
        $(document).ready(function(){
          Site.run();
        });
      })(document, window, jQuery);
    </script>
    
  </body>
</html>
