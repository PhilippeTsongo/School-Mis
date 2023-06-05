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
      @include('../../partials.aside')


      <div class="main-panel">
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="home-tab">

                            @foreach($production_comptables as $production_comptable)
                            <div class="d-sm-flex align-items-center justify-content-between border-bottom">
                                <ul class="nav nav-tabs" role="tablist">
                                    
                                </ul>
                                <div>
                                    <div class="btn-wrapper">
                                        <a href="#" class="btn btn-otline-dark align-items-center"><i class="icon-share"></i> Share</a>
                                        <a href="#" class="btn btn-otline-dark"><i class="icon-printer"></i> Print</a>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-content tab-content-basic">
                                <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview"> 
                                    <div class="row">
                                        <div class="col-md-12 ">
                                            <div class="card card-rounded">
                                                <div class="card-body">
                                                    <div class="d-sm-flex justify-content-between align-items-start">
                                                        <div>
                                                            <h4 class="card-title card-title-dash">Balance de la production [{{$production_comptable->number}}]</h4>
                                                            <p class="card-subtitle card-subtitle-dash">Cette partie illustre la différence entre le prix total de la production et le coup de la production </p>
                                                        </div>
                                                       
                                                    </div>
                                                    <div class="d-sm-flex align-items-center mt-1 justify-content-between">
                                                        <div class="d-sm-flex align-items-center mt-4 justify-content-between">
                                                            <h2 class="me-2 fw-bold">
                                                                <span class="text-info"> 
                                                                    {{ number_format($production_comptable->sale_price * $production_comptable->quantity, 02) .'$' }} -
                                                                </span>
                                                                <span class="text-danger"> 
                                                                    <?php 
                                                                    //calcul du cout de production
                                                                        $matieres = DB::table('matieres')->where('id', $production_comptable->matiere->id)->get();
                                                                        $emballages = DB::table('emballages')->where('id', $production_comptable->emballage->id)->get();
                                                                        
                                                                        foreach($matieres as $matiere){
                                                                            foreach($emballages as $emballage){
                                                                                $matiere_price = $matiere->{'purchase_price'};
                                                                                $emballage_price = $emballage->{'purchase_price'};

                                                                                //calcul du cout de production
                                                                                $amount_emballage = $production_comptable->emballage_quantity * $emballage_price; 
                                                                                $amount_matiere = $production_comptable->matiere_quantity * $matiere_price;
                                                                                $total_cout_production = $amount_emballage + $amount_matiere;  
                                                                            }
                                                                        }
                                                                    ?>
                                                                    {{ number_format($total_cout_production, 02) .'$  = '  }}
                                                                </span>
                                                            </h2>

                                                            
                                                            <h4 class="text-success">
                                                                {{ number_format($production_comptable->sale_price * $production_comptable->quantity - $total_cout_production, 02 ) .'$' }} 
                                                            </h4>
                                                        </div>
                                                        <div class="me-3"><div id="marketing-overview-legend"></div></div>
                                                    </div>                               
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                        
                                        <div class="col-md-4 grid-margin stretch-card">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h4 class="card-title">Catégorie</h4>
                                                    <div class="media">
                                                    <i class="ti-world icon-md text-info d-flex align-self-end me-3"></i>
                                                    <div class="media-body">
                                                        @if($production_comptable->category)

                                                        <div class="badge badge-opacity-warning">{{ $production_comptable->category->name }} </div>
                                                    @else
                                                        <p class="card-text">{{'Pas de catégorie '}}</p>
                                                    @endif
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 grid-margin stretch-card">
                                            <div class="card">
                                            <div class="card-body">
                                                <h4 class="card-title">Matières Premières Utilisées</h4>
                                                <div class="media">
                                                    <i class="ti-world icon-md text-info d-flex align-self-start me-3"></i>
                                                    <div class="media-body">
                                                        @if($production_comptable->matiere)
                                                            <p class="card-text">{{ $production_comptable->matiere_quantity .' '. $production_comptable->matiere->unit->name .' '.  $production_comptable->matiere->name .' ' }} </p>
                                                        @else
                                                            <p class="card-text">{{'Pas de matières utilisées '}}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 grid-margin stretch-card">
                                            <div class="card">
                                            <div class="card-body">
                                                <h4 class="card-title">Emballages</h4>
                                                <div class="media">
                                                    <i class="ti-world icon-md text-info d-flex align-self-center me-3"></i>
                                                    <div class="media-body">
                                                        @if($production_comptable->emballage)
                                                            <p class="card-text">{{ $production_comptable->emballage->quantity .' '. $production_comptable->emballage->unit->name .' '.  $production_comptable->emballage->name .' ' }} </p>
                                                        @else
                                                            <p class="card-text">{{'Pas d\'emballage utilisées '}}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12 grid-margin stretch-card">
                                            <div class="card">
                                              <div class="card-body">
                                                <h4 class="card-title">Element de la production {{ $production_comptable->number }}</h4>
                                                
                                                <div class="table-responsive">
                                                  <table class="table table-striped">
                                                    <thead>
                                                      <tr>
                                                        <th>
                                                          #
                                                        </th>
                                                        <th>Quantité</th>
                                                        <th> Prix de vente</th>
                                                        <th>Prix total</th>
                                                        <th>date de production</th>
                                                        
                                                      </tr>
                                                    </thead>
                                                    <tbody>
                                                      <tr>
                                                        
                                                        <td>{{ $production_comptable->number }}</td>
                                                        <td>
                                                            {{ $production_comptable->quantity }}
                                                            @if($production_comptable->unit)
                                                                {{ $production_comptable->unit->name}}
                                                            @endif
                                                        </td>
                                                        <td class="text-danger">{{ number_format($production_comptable->sale_price, 02) . '$'}}</td>
                                                        <td> 
                                                            <div class="badge badge-opacity-warning">
                                                                {{ number_format($production_comptable->quantity * $production_comptable->sale_price, 02) .'$' }}
                                                            </div>
                                                        </td>
                                                        <td>{{ $production_comptable->created_at }}</td>
                                                      
                                                      </tr>
                                                    </tbody>
                                                  </table>
                                                </div>
                                              </div>
                                            </div>
                                        </div>
                                        

                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
  </div>
        </div>
        
        
        @include('../../partials.footer')
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

