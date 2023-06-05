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
                                <a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#month" role="tab" aria-selected="false">Mensuelles [{{ $monthly }}]</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active ps-0" id="contact-tab" data-bs-toggle="tab" href="#year" role="tab" aria-controls="year" aria-selected="true">Annuelles [{{ $yearly }}]</a>
                            </li>
                        </ul>
                        <div>
                            <div class="btn-wrapper">
                                <a href="#" class="btn btn-otline-dark align-items-center"><i class="icon-share"></i> Share</a>
                                <a href="#" class="btn btn-otline-dark"><i class="icon-printer"></i> Print</a>
                                <a href="{{ route('production.create')}}" class="btn btn-primary text-white me-0"><i class="mdi mdi-plus-circle-outline"></i> Nouvelle production</a>
                            </div>
                        </div>
                    </div>
                
                <div class="tab-content tab-content-basic">
                    {{-- Daily--}}
                    <div class="tab-pane fade show" id="daily" role="tabpanel" aria-labelledby="daily"> 
                        
                        <div class="row">
                        
                            <div class="col-lg-12 grid-margin stretch-card">
                                <div class="card">
                                <div class="card-body">
                                    <div class="d-sm-flex justify-content-between align-items-start">
                                    
                                        <div>
                                            <h4 class="card-title">Liste de productions journalières [{{ $today }}]</h4>
                                        </div>
                                        <div id="performance-line-legend"></div>
                                        
                                        <div>
                                            <a href="{{ route('production.create')}}" class="btn btn-primary btn-lg text-white mb-0 me-0"><i class="mdi mdi-plus-circle-outline"></i>Nouvelle production</a>
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
                                                    <th>Catégorie</th>
                                                    <th>Quantité</th>
                                                    <th>Prix de vente</th>
                                                    <th>Prix Total</th>
                                                    <th>Cout de production</th>
                                                    <th>Matière première</th>
                                                    <th>Emballage</th>
                                                    <th>Date</th>

                                                    @if(Auth()->check())
                                                        @if(Auth::user()->user_type_id == 1)
                                                            <th>Action</th>
                                                        @endif
                                                    @endif
                                                </tr>
                                            </thead>
                                        <tbody>
                                            @foreach($dailys as $daily)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('production.show', $daily)}}" style="text-decoration:none" title="Voir le detail production">
                                                        {{ $daily->number }}
                                                    </a>
                                                </td>
                                                <td>
                                                    @if($daily->category)
                                                        <div class="badge badge-opacity-warning">{{$daily->category->name}}</div>
                                                    @endif
                                                </td>
                                                
                                                <td>{{ $daily->quantity }}  
                                                    @if($daily->unit)
                                                        {{ $daily->unit->name }}
                                                    @endif
                                                </td>
                                                <td>{{ number_format($daily->sale_price, 02 ). '$'}}</td>
                                                <td>
                                                    <div class="badge badge-opacity-warning"> {{ number_format($daily->quantity * $daily->sale_price, 02 ) .'$' }}  </div>
                                                </td>

                                                <td class="text-danger">
                                                    <?php //calcul du cout de production
                                                    if($daily->emballage && $daily->matiere)
                                                    {
                                                        $matieres = DB::table('matieres')->where('id', $daily->matiere->id)->get();
                                                        $emballages = DB::table('emballages')->where('id', $daily->emballage->id)->get();
                                                        
                                                        foreach($matieres as $matiere){
                                                            foreach($emballages as $emballage){
                                                                $matiere_price = $matiere->{'purchase_price'};
                                                                $emballage_price = $emballage->{'purchase_price'};

                                                                //calcul du cout de production
                                                                $amount_emballage = $daily->emballage_quantity * $emballage_price; 
                                                                $amount_matiere = $daily->matiere_quantity * $matiere_price;
                                                                $total_cout_production = $amount_emballage + $amount_matiere;  
                                                          
                                                            }
                                                        }
                                                        echo number_format($total_cout_production, 02 ).'$'; 
                                                    }
                                                    ?>
                                                </td>
                                                
                                                <td>{{ $daily->matiere->name }} {{ $daily->matiere_quantity }} {{ $daily->emballage->unit->name }}</td>
                                                <td>{{ $daily->emballage->name }} {{ $daily->emballage_quantity }} {{ $daily->emballage->unit->name }}</td>
                                                <td>{{ $daily->created_at->format('d-M-Y') }}</td>
                                                <td>
                                                    @if(Auth()->check())
                                                        @if(Auth::user()->user_type_id == 1)
                                                        <div class="row">
                                                            <div class="col-lg-3">
                                                                <a href="{{ route('production.show', $daily)}}" title="Voir la production">
                                                                    <i class="mdi mdi-eye"></i> 
                                                                </a>
                                                            </div>
                                                            {{--  edit  --}}
                                                            {{-- <div class="col-lg-3">
                                                                <a href="{{ route('production.edit', ['production' => $daily->id]) }}" _method="GET" 
                                                                    onClick="return confirm('Voulez-vous vraiment modifier cette production?');" title="Modifier cette production"> 
                                                                    <i class="mdi mdi-pencil text-info"></i>
                                                                </a>
                                                            </div>   --}}
                                                            <div class="col-lg-3">
                                                                {{-- delete --}}
                                                                <form action="{{ route('production.destroy', ['production' => $daily->id ]  ) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer cette production?');">
                                                                    {{ csrf_field() }}
                                                                    {{ method_field('DELETE') }}
                                                                    <button type="submit" style="border:none; background: none" title="Supprimez cette production" > <i class="mdi mdi-delete-forever text-danger"></i></button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        @endif
                                                    @endif

                                                <td></td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    </div>
                                </div>
                                </div>
                            </div>
                        
                            {{-- <div class="col-lg-3 d-flex flex-column">
                                <div class="row flex-grow">
                                    <div class="col-md-6 col-lg-12 grid-margin">
                                        <div class="card bg-primary card-rounded">
                                            <div class="card-body pb-0">
                                                <h4 class="card-title card-title-dash text-white mb-4">Nombre de productions </h4>
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <p class="status-summary-ight-white mb-1">Total</p>
                                                        <h2 class="text-info">{{ $productions->count()}}</h2>
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
                            </div> --}}
                        </div>
                        
                    </div>

                    {{-- Month--}}
                    <div class="tab-pane fade show" id="month" role="tabpanel" aria-labelledby="month"> 
                        
                        <div class="row">
                        
                            <div class="col-lg-12 grid-margin stretch-card">
                                <div class="card">
                                <div class="card-body">
                                    <div class="d-sm-flex justify-content-between align-items-start">
                                    
                                        <div>
                                            <h4 class="card-title">Liste de productions Mensuelles [{{ $monthly }}]</h4>
                                        </div>
                                        <div id="performance-line-legend"></div>
                                        
                                        <div>
                                            <a href="{{ route('production.create')}}" class="btn btn-primary btn-lg text-white mb-0 me-0"><i class="mdi mdi-plus-circle-outline"></i>Nouvelle production</a>
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
                                                    <th>Catégorie</th>
                                                    <th>Quantité</th>
                                                    <th>Prix de vente</th>
                                                    <th>Prix Total</th>
                                                    <th>Cout de production</th>
                                                    <th>Matière première</th>
                                                    <th>Emballage</th>
                                                    <th>Date</th>

                                                    @if(Auth()->check())
                                                        @if(Auth::user()->user_type_id == 1)
                                                            <th>Action</th>
                                                        @endif
                                                    @endif
                                                </tr>
                                            </thead>
                                        <tbody>
                                            @foreach($months as $month)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('production.show', $month)}}" style="text-decoration:none" title="Voir le detail production">
                                                        {{ $month->number }}
                                                    </a>
                                                </td>
                                                <td>
                                                    @if($month->category)
                                                        <div class="badge badge-opacity-warning">{{$month->category->name}}</div>
                                                    @endif
                                                </td>
                                                
                                                <td>{{ $month->quantity }}  
                                                    @if($month->unit)
                                                        {{ $month->unit->name }}
                                                    @endif
                                                </td>
                                                <td>{{ number_format($month->sale_price, 02). '$'}}</td>

                                                <td>
                                                    <div class="badge badge-opacity-warning"> {{ number_format($month->quantity * $month->sale_price, 02 ) .'$' }}  </div>
                                                </td>
                                                
                                                <td class="text-danger">
                                                    <?php //calcul du cout de production
                                                    if($month->emballage && $month->matiere)
                                                    {
                                                        $matieres = DB::table('matieres')->where('id', $month->matiere->id)->get();
                                                        $emballages = DB::table('emballages')->where('id', $month->emballage->id)->get();
                                                        
                                                        foreach($matieres as $matiere){
                                                            foreach($emballages as $emballage){
                                                                $matiere_price = $matiere->{'purchase_price'};
                                                                $emballage_price = $emballage->{'purchase_price'};

                                                                //calcul du cout de production
                                                                $amount_emballage = $month->emballage_quantity * $emballage_price; 
                                                                $amount_matiere = $month->matiere_quantity * $matiere_price;
                                                                $total_cout_production = $amount_emballage + $amount_matiere;  
                                                          
                                                            }
                                                        }
                                                        echo number_format($total_cout_production, 02 ).'$'; 
                                                    }
                                                    ?>
                                                </td>
                                                
                                                <td>{{ $month->matiere->name }} {{ $month->matiere_quantity }} 
                                                    @if($month->matiere->unit)
                                                        {{ $month->matiere->unit->name }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($month->emabllage)
                                                        {{ $month->emballage->name }} {{ $month->emballage_quantity }} 
                                                    @endif
                                                    @if($month->emballage)
                                                        @if($month->emballage->unit)
                                                            {{ $month->emballage->unit->name }}
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>{{ $month->created_at->format('d-M-Y') }}</td>
                                                <td>
                                                    @if(Auth()->check())
                                                        @if(Auth::user()->user_type_id == 1)
                                                        <div class="row">
                                                            <div class="col-lg-3">
                                                                <a href="{{ route('production.show', $month)}}" title="Voir la production">
                                                                    <i class="mdi mdi-eye"></i> 
                                                                </a>
                                                            </div>
                                                            {{--  edit  --}}
                                                            {{-- <div class="col-lg-3">
                                                                <a href="{{ route('production.edit', ['production' => $month->id]) }}" _method="GET" 
                                                                    onClick="return confirm('Voulez-vous vraiment modifier cette production?');" title="Modifier cette production"> 
                                                                    <i class="mdi mdi-pencil text-info"></i>
                                                                </a>
                                                            </div>   --}}
                                                            <div class="col-lg-3">
                                                                {{-- delete --}}
                                                                <form action="{{ route('production.destroy', ['production' => $month->id ]  ) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer cette production?');">
                                                                    {{ csrf_field() }}
                                                                    {{ method_field('DELETE') }}
                                                                    <button type="submit" style="border:none; background: none" title="Supprimez cette production" > <i class="mdi mdi-delete-forever text-danger"></i></button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        @endif
                                                    @endif

                                                <td></td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    </div>
                                </div>
                                </div>
                            </div>
                        
                            {{-- <div class="col-lg-3 d-flex flex-column">
                                <div class="row flex-grow">
                                    <div class="col-md-6 col-lg-12 grid-margin">
                                        <div class="card bg-primary card-rounded">
                                            <div class="card-body pb-0">
                                                <h4 class="card-title card-title-dash text-white mb-4">Nombre de productions </h4>
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <p class="status-summary-ight-white mb-1">Total</p>
                                                        <h2 class="text-info">{{ $productions->count()}}</h2>
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
                            </div> --}}
                        </div>
                        
                    </div>

                    {{-- Years --}}
                    <div class="tab-pane fade show active" id="year" role="tabpanel" aria-labelledby="year"> 
                        
                        <div class="row">
                        
                            <div class="col-lg-12 grid-margin stretch-card">
                                <div class="card">
                                <div class="card-body">
                                    <div class="d-sm-flex justify-content-between align-items-start">
                                    
                                        <div>
                                            <h4 class="card-title">Liste de productions Annuelles [{{ $yearly }}]</h4>
                                        </div>
                                        <div id="performance-line-legend"></div>
                                        
                                        <div>
                                            <a href="{{ route('production.create')}}" class="btn btn-primary btn-lg text-white mb-0 me-0"><i class="mdi mdi-plus-circle-outline"></i>Nouvelle production</a>
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
                                                    <th>Catégorie</th>
                                                    <th>Quantité</th>
                                                    <th>Prix de vente</th>
                                                    <th>Prix Total</th>
                                                    <th>Cout de production</th>
                                                    <th>Matière première</th>
                                                    <th>Emballage</th>
                                                    <th>Date</th>

                                                    @if(Auth()->check())
                                                        @if(Auth::user()->user_type_id == 1)
                                                            <th>Action</th>
                                                        @endif
                                                    @endif
                                                </tr>
                                            </thead>
                                        <tbody>
                                            @foreach($years as $year)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('production.show', $year)}}" style="text-decoration:none" title="Voir le detail production">
                                                        {{ $year->number }}
                                                    </a>
                                                </td>
                                                <td>
                                                    @if($year->category)
                                                        <div class="badge badge-opacity-warning">{{$year->category->name}}</div>
                                                    @endif
                                                </td>
                                                
                                                <td>{{ $year->quantity }}  
                                                    @if($year->unit)
                                                        {{ $year->unit->name }}
                                                    @endif
                                                </td>
                                                <td>{{ number_format($year->sale_price, 02). '$'}}</td>

                                                <td>
                                                    <div class="badge badge-opacity-warning"> {{ number_format($year->quantity * $year->sale_price, 02 ) .'$' }}  </div>
                                                </td>
                                                
                                                <td class="text-danger">
                                                    <?php //calcul du cout de production
                                                    if($year->emballage && $year->matiere)
                                                    {
                                                        $matieres = DB::table('matieres')->where('id', $year->matiere->id)->get();
                                                        $emballages = DB::table('emballages')->where('id', $year->emballage->id)->get();
                                                        
                                                        foreach($matieres as $matiere){
                                                            foreach($emballages as $emballage){
                                                                $matiere_price = $matiere->{'purchase_price'};
                                                                $emballage_price = $emballage->{'purchase_price'};

                                                                //calcul du cout de production
                                                                $amount_emballage = $year->emballage_quantity * $emballage_price; 
                                                                $amount_matiere = $year->matiere_quantity * $matiere_price;
                                                                $total_cout_production = $amount_emballage + $amount_matiere;  
                                                          
                                                            }
                                                        }
                                                        echo number_format($total_cout_production, 02 ).'$'; 
                                                    }
                                                    ?>
                                                </td>
                                                
                                                <td>
                                                    @if($year->matiere)
                                                        {{ $year->matiere->name }} {{ $year->matiere_quantity }} 
                                                        @if($year->matiere->unit)
                                                            {{ $year->matiere->unit->name }}
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($year->emballage)
                                                        {{ $year->emballage->name }} {{ $year->emballage_quantity }} 
                                                        @if($year->emballage->unit)
                                                            {{ $year->emballage->unit->name }}
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>{{ $year->created_at->format('d-M-Y') }}</td>
                                                <td>
                                                    @if(Auth()->check())
                                                        @if(Auth::user()->user_type_id == 1)
                                                        <div class="row">
                                                            <div class="col-lg-3">
                                                                <a href="{{ route('production.show', $year)}}" title="Voir la production">
                                                                    <i class="mdi mdi-eye"></i> 
                                                                </a>
                                                            </div>
                                                            {{--  edit  --}}
                                                            {{-- <div class="col-lg-3">
                                                                <a href="{{ route('production.edit', ['production' => $year->id]) }}" _method="GET" 
                                                                    onClick="return confirm('Voulez-vous vraiment modifier cette production?');" title="Modifier cette production"> 
                                                                    <i class="mdi mdi-pencil text-info"></i>
                                                                </a>
                                                            </div>   --}}
                                                            <div class="col-lg-3">
                                                                {{-- delete --}}
                                                                <form action="{{ route('production.destroy', ['production' => $year->id ]  ) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer cette production?');">
                                                                    {{ csrf_field() }}
                                                                    {{ method_field('DELETE') }}
                                                                    <button type="submit" style="border:none; background: none" title="Supprimez cette production" > <i class="mdi mdi-delete-forever text-danger"></i></button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        @endif
                                                    @endif

                                                <td></td>
                                            </tr>
                                            @endforeach
                                        <br>    
                                        {{ $years->links('vendor.pagination.bootstrap-5')}}
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

