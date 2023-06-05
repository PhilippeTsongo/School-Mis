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
                                <a class="nav-link" id="home-tab" data-bs-toggle="tab" href="#daily" role="tab" aria-selected="false">Aujourd'hui [{{ $today }}]</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#month" role="tab" aria-selected="false">Mensuelles [{{ $month }}]</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active ps-0" id="contact-tab" data-bs-toggle="tab" href="#year" role="tab" aria-controls="year" aria-selected="true">Annuelles [{{ $year }}]</a>
                            </li>
                        </ul>
                        <div>
                            <div class="btn-wrapper">
                                <a href="#" class="btn btn-otline-dark align-items-center"><i class="icon-share"></i> Share</a>
                                <a href="#" class="btn btn-otline-dark"><i class="icon-printer"></i> Print</a>
                                <a href="{{ route('dette.create')}}" class="btn btn-primary text-white me-0"><i class="mdi mdi-plus-circle-outline"></i> Nouvelle dette</a>
                            </div>
                        </div>
                    </div>
                
                <div class="tab-content tab-content-basic">
                  
                    {{-- daily --}}
                <div class="tab-pane fade show" id="daily" role="tabpanel" aria-labelledby="daily"> 
                    <div class="row">
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                              <div class="card-body">
                                <div class="d-sm-flex justify-content-between align-items-start">
                                    <div>
                                        <h4 class="card-title">Liste de Dettes Journalières [{{ $today }}]</h4>
                                    </div>
                                    <div id="performance-line-legend"></div>
                                    
                                    <div>
                                        <a href="{{ route('dette.create')}}" class="btn btn-primary btn-lg text-white mb-0 me-0"><i class="mdi mdi-plus-circle-outline"></i>Nouvelle dette</a>
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
                                                <th>Informations de vente</th>                                                
                                                <th>Montant</th>
                                                <th>Date</th>
                                                <th>Nom Du Client</th>
                                                <th>Numéro de Tél</th>
                                                <th>Adresse</th>
                                                @if(Auth()->check())
                                                    @if(Auth::user()->user_type_id == 1)
                                                        <th>Action</th>
                                                    @endif
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $total = 0; ?>
                                            @foreach($dailys as $daily)
                                            <tr>
                                                <td>{{ $daily->dette_number}}</td>

                                                <td>
                                                    Vente numéro  
                                                    {{ $daily->sale->sale_number }} de {{ $daily->sale->quantity . $daily->sale->production->unit->name }}  
                                                    de {{ $daily->sale->production->category->name }} à {{ $daily->sale->price .'$'}}
                                                </td>
                                                <td class="text-danger">{{  number_format($daily->montant, 02) .'$' }}</td>
                                                <td >{{ $daily->date_dette }}</td>
                                                <td >
                                                    @if($daily->sale)
                                                        {{ $daily->sale->client->name}}
                                                    @endif
                                                </td>
                                                <td >
                                                    @if($daily->sale)
                                                        {{ $daily->sale->client->tel}}
                                                    @endif
                                                </td>
                                                <td >
                                                    @if($daily->sale)
                                                        {{ $daily->sale->client->address}}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(Auth()->check())
                                                        @if(Auth::user()->user_type_id == 1)
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                {{--  edit  --}}
                                                                <a href="{{ route('dette.edit', ['dette' => $daily->id]) }}" _method="GET" 
                                                                    onClick="return confirm('Voulez-vous vraiment modifier cette dette?');" title="Modifier cette dette"> 
                                                                    <i class="mdi mdi-pencil text-info"></i>
                                                                </a>
                                                            </div>  
                                                            <div class="col-lg-6">
                                                                {{-- delete --}}
                                                                <form action="{{ route('dette.destroy', ['dette' => $daily->id ]  ) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer cette dette?');">
                                                                    {{ csrf_field() }}
                                                                    {{ method_field('DELETE') }}
                                                                    <button type="submit" style="border:none; background: none" title="Supprimez cette dette" > <i class="mdi mdi-delete-forever text-danger"></i></button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        @endif
                                                    @endif

                                                </td>
                                            </tr>

                                            <?php  $total = $total + ( $daily->montant); ?>
                                            @endforeach
                                            <tr>
                                                <td colspan="2">
                                                    Total 
                                                </td>
                                                <td colspan="3"> <div class="badge badge-opacity-warning"><b><?= number_format($total, 02) .'$' ?></b></div> </td>
                                            </tr>
                                        </tbody>
                                  </table>
                                </div>
                              </div>
                            </div>
                          </div>
                    
                    </div> 
                </div>

                {{-- month --}}
                <div class="tab-pane fade show" id="month" role="tabpanel" aria-labelledby="month"> 
                    <div class="row">
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                              <div class="card-body">
                                <div class="d-sm-flex justify-content-between align-items-start">
                                    <div>
                                        <h4 class="card-title">Liste de Dettes Mensuelles [{{ $month }}]</h4>
                                    </div>
                                    <div id="performance-line-legend"></div>
                                    
                                    <div>
                                        <a href="{{ route('dette.create')}}" class="btn btn-primary btn-lg text-white mb-0 me-0"><i class="mdi mdi-plus-circle-outline"></i>Nouvelle dette</a>
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
                                                <th>Informations de Vente</th>
                                                <th>Montant</th>
                                                <th>Date</th>
                                                <th>Nom Du Client</th>
                                                <th>Numéro de Tél</th>
                                                <th>Adresse</th>
                                                @if(Auth()->check())
                                                    @if(Auth::user()->user_type_id == 1)
                                                        <th>Action</th>
                                                    @endif
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $total = 0; ?>
                                            @foreach($months as $month)
                                            <tr>
                                                <td>{{$month->dette_number}}</td>

                                                <td>
                                                    Vente numéro  
                                                    {{ $month->sale->sale_number }} de {{ $month->sale->quantity . $month->sale->production->unit->name }}  
                                                    de {{ $month->sale->production->category->name }} à {{ $month->sale->price .'$'}}
                                                </td>

                                                <td class="text-danger">{{  number_format($month->montant, 02) .'$' }}</td>
                                                <td >{{ $month->date_dette }}</td>
                                                <td>
                                                    @if($month->sale)        
                                                        {{ $month->sale->client->name}}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($month->sale)        
                                                        {{ $month->sale->client->tel}}
                                                    @endif    
                                                </td>
                                                <td>
                                                    @if($month->sale)        
                                                        {{ $month->sale->client->address}}
                                                    @endif    
                                                </td>
                                                <td>
                                                    @if(Auth()->check())
                                                        @if(Auth::user()->user_type_id == 1)
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                {{--  edit  --}}
                                                                <a href="{{ route('dette.edit', ['dette' => $month->id]) }}" _method="GET" 
                                                                    onClick="return confirm('Voulez-vous vraiment modifier cette dette?');" title="Modifier cette dette"> 
                                                                    <i class="mdi mdi-pencil text-info"></i>
                                                                </a>
                                                            </div>  
                                                            <div class="col-lg-6">
                                                                {{-- delete --}}
                                                                <form action="{{ route('dette.destroy', ['dette' => $month->id ]  ) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer cette dette?');">
                                                                    {{ csrf_field() }}
                                                                    {{ method_field('DELETE') }}
                                                                    <button type="submit" style="border:none; background: none" title="Supprimez cette dette" > <i class="mdi mdi-delete-forever text-danger"></i></button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        @endif
                                                    @endif
                                                </td>
                                            </tr>

                                            <?php  $total = $total + ( $month->montant); ?>
                                            @endforeach
                                            <tr>
                                                <td colspan="2">
                                                    Total 
                                                </td>
                                                <td colspan="3"> <div class="badge badge-opacity-warning"><b><?= number_format($total, 02) .'$' ?></b></div> </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                              </div>
                            </div>
                          </div>
                    
                    </div>
                    
                  </div>

                  {{-- year --}}
                  <div class="tab-pane fade show active" id="year" role="tabpanel" aria-labelledby="month"> 
                    <div class="row">
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                              <div class="card-body">
                                <div class="d-sm-flex justify-content-between align-items-start">
                                    <div>
                                        <h4 class="card-title">Liste de Dettes Annuelles [{{ $year }}]</h4>
                                    </div>
                                    <div id="performance-line-legend"></div>
                                    
                                    <div>
                                        <a href="{{ route('dette.create')}}" class="btn btn-primary btn-lg text-white mb-0 me-0"><i class="mdi mdi-plus-circle-outline"></i>Nouvelle dette</a>
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
                                                <th>Infornmations de Vente</th>
                                                <th>Montant</th>
                                                <th>Date</th>
                                                <th>Nom Du Client</th>
                                                <th>Numéro de Tél</th>
                                                <th>Adresse</th>
                                                @if(Auth()->check())
                                                    @if(Auth::user()->user_type_id == 1)
                                                        <th>Action</th>
                                                    @endif
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $total = 0; ?>
                                            @foreach($years as $year)
                                            <tr>
                                                <td>{{ $year->dette_number}}</td>
                                                <td>
                                                    Vente numéro  
                                                    {{ $year->sale->sale_number }} de {{ $year->sale->quantity . $year->sale->production->unit->name }}  
                                                    de {{ $year->sale->production->category->name }} à {{ $year->sale->price .'$'}}
                                                </td>
                                                <td class="text-danger">{{  number_format($year->montant, 02) .'$' }}</td>
                                                <td >{{ $year->date_dette }}</td>
                                                <td >
                                                    @if($year->sale)        
                                                        {{ $year->sale->client->name}}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($year->sale)        
                                                        {{ $year->sale->client->tel}}
                                                    @endif    
                                                </td>
                                                <td>
                                                    @if($year->sale)        
                                                        {{ $year->sale->client->address}}
                                                    @endif    
                                                </td>
                                                <td>
                                                    @if(Auth()->check())
                                                        @if(Auth::user()->user_type_id == 1)
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                {{--  edit  --}}
                                                                <a href="{{ route('dette.edit', ['dette' => $year->id]) }}" _method="GET" 
                                                                    onClick="return confirm('Voulez-vous vraiment modifier cette dette?');" title="Modifier cette dette"> 
                                                                    <i class="mdi mdi-pencil text-info"></i>
                                                                </a>
                                                            </div>  
                                                            <div class="col-lg-6">
                                                                {{-- delete --}}
                                                                <form action="{{ route('dette.destroy', ['dette' => $year->id ]  ) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer cette dette?');">
                                                                    {{ csrf_field() }}
                                                                    {{ method_field('DELETE') }}
                                                                    <button type="submit" style="border:none; background: none" title="Supprimez cette dette" > <i class="mdi mdi-delete-forever text-danger"></i></button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        @endif
                                                    @endif
                                                </td>
                                            </tr>
                                            <?php  $total = $total + ( $year->montant); ?>
                                            @endforeach
                                            <tr>
                                                <td colspan="2">
                                                    Total 
                                                </td>
                                                <td colspan="3"> <div class="badge badge-opacity-warning"><b><?= number_format($total, 02) .'$' ?></b></div> </td>
                                            </tr>

                                            <br>
                                            {{ $years->links('vendor.pagination.bootstrap-5') }}
                                        </tbody>
                                    </table>
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

