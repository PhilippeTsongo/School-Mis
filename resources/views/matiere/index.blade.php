<!DOCTYPE html>
<html lang="en">
 

  <title>Kanabe Système</title>

  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- plugins:css -->
    <link rel="stylesheet" href="../../vendors/feather/feather.css">
    <link rel="stylesheet" href="../../vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../../vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="../../vendors/typicons/typicons.css">
    <link rel="stylesheet" href="../../vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="../../vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="../../vendors/datatables.net-bs4/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="../../js/select.dataTables.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="../../css/vertical-layout-light/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="../../images/favicon.png" />
</head>
      

  @extends('layouts.app')
  
  @section('content')
    
  <div class="container-scroller">
    <!-- header   -->

    <div class="container-fluid page-body-wrapper">
      {{-- aside --}}
      @include('partials.aside')


      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-sm-12">
              <div class="home-tab">

                    <div class="d-sm-flex align-items-center justify-content-between border-bottom">
                        <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active ps-0" id="home-tab" data-bs-toggle="tab" href="#overview" role="tab" aria-controls="overview" aria-selected="true">Overview</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#audiences" role="tab" aria-selected="false">Audiences</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="contact-tab" data-bs-toggle="tab" href="#demographics" role="tab" aria-selected="false">Demographics</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link border-0" id="more-tab" data-bs-toggle="tab" href="#more" role="tab" aria-selected="false">More</a>
                        </li>
                        </ul>
                        <div>
                            <div class="btn-wrapper">
                                <a href="#" class="btn btn-otline-dark align-items-center"><i class="icon-share"></i> Share</a>
                                <a href="#" class="btn btn-otline-dark"><i class="icon-printer"></i> Print</a>
                                <a href="{{ route('matiere.create')}}" class="btn btn-primary text-white me-0"><i class="mdi mdi-plus-circle-outline"></i> Nouvelle Matière</a>
                            </div>
                        </div>
                    </div>
                
                <div class="tab-content tab-content-basic">
                  <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview"> 
                     
                    <div class="row">
                      
                        <div class="col-lg-9 grid-margin stretch-card">
                            <div class="card">
                              <div class="card-body">
                                <div class="d-sm-flex justify-content-between align-items-start">
                                   
                                    <div>
                                        <h4 class="card-title">Liste de matières premières</h4>
                                    </div>
                                    <div id="performance-line-legend"></div>
                                    
                                    <div>
                                        <a href="{{ route('matiere.create')}}" class="btn btn-primary btn-lg text-white mb-0 me-0"><i class="mdi mdi-plus-circle-outline"></i>Nouvelle Matière</a>
                                    </div>

                                </div>
                                <div>
                                    <div>
                                        @include('../partials/message')
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nom</th>
                                                <th>Type</th>
                                                <th>Quantité</th>
                                                <th>Prix d'achat</th>
                                                <th>Date</th>
                                                @if(Auth()->check())
                                                    @if(Auth::user()->user_type_id == 1)
                                                        <th>Action</th>
                                                    @endif
                                                @endif
                                            </tr>
                                        </thead>
                                    <tbody>
                                        @foreach($matieres as $matiere)
                                        <tr>
                                            <td>{{ $matiere->matiere_number}}</td>
                                            <td>{{$matiere->name}}</td>

                                            <td><div class="badge badge-opacity-warning">{{$matiere->type}}</div></td>
                                            
                                            <td>{{ $matiere->quantity }} {{$matiere->unit->name}}</td>
                                            <td class="text-warning">{{  number_format($matiere->purchase_price, 02) .'$'}} </td>
                                            <td>{{ $matiere->date_matiere }} </td>
                                            
                                            <td>
                                                @if(Auth()->check())
                                                    @if(Auth::user()->user_type_id == 1)
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            {{--  edit  --}}
                                                            <a href="{{ route('matiere.edit', ['matiere' => $matiere->id]) }}" _method="GET" 
                                                                onClick="return confirm('Voulez-vous vraiment modifier cette matière?');" title="Modifier cette matière"> 
                                                                <i class="mdi mdi-pencil text-info"></i>
                                                            </a>
                                                        </div>  
                                                        <div class="col-lg-6">
                                                            {{-- delete --}}
                                                            <form action="{{ route('matiere.destroy', ['matiere' => $matiere->id ]  ) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer cette matière?');">
                                                                {{ csrf_field() }}
                                                                {{ method_field('DELETE') }}
                                                                <button type="submit" style="border:none; background: none" title="Supprimez cette matière" > <i class="mdi mdi-delete-forever text-danger"></i></button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                        <br>

                                        {{ $matieres->links('vendor.pagination.bootstrap-5')}}
                                    </tbody>
                                  </table>
                                </div>
                              </div>
                            </div>
                          </div>
                      
                        <div class="col-lg-3 d-flex flex-column">
                            <div class="row flex-grow">
                                <div class="col-md-6 col-lg-12 grid-margin">
                                    <div class="card bg-primary card-rounded">
                                        <div class="card-body pb-0">
                                            <h4 class="card-title card-title-dash text-white mb-4">Nombre de matières premières</h4>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <p class="status-summary-ight-white mb-1">Total</p>
                                                    <h2 class="text-info">{{ $matieres->count()}}</h2>
                                                </div>
                                                <div class="col-sm-8">
                                                    <div class="status-summary-chart-wrapper pb-4">
                                                        <canvas id="status-summary"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            
                            </div>
                        </div>
                    </div>
                    
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        @include('partials.footer')
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->

  <!-- plugins:js -->
  <script src="../../vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="../../vendors/chart.js/Chart.min.js"></script>
  <script src="../../vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
  <script src="../../vendors/progressbar.js/progressbar.min.js"></script>

  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="../../js/off-canvas.js"></script>
  <script src="../../js/hoverable-collapse.js"></script>
  <script src="../../js/template.js"></script>
  <script src="../../js/settings.js"></script>
  <script src="../../js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="../../js/jquery.cookie.js" type="text/javascript"></script>
  <script src="../../js/dashboard.js"></script>
  <script src="../../js/Chart.roundedBarCharts.js"></script>
  <!-- End custom js for this page-->


</html>

