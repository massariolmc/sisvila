@extends('layouts.layout_sem_sidebar')

@section('content')
<div class="container">
    <div class="row align-items-center">
        <div class="col-md-2">
            <img src="/imagens/sisvila2.png" width="80px" height="70px">        
        </div>
        <div class="col-md-10">
            <h2>Saidas de Visitantes Cadastrados</h2>
        </div>
    </div>
    
    <hr>
    @if (in_array('ad', $userProfiles) || in_array('po', $userProfiles))
        <div class="row">
            <div class="col-md-4 mb-3">
                <a href="{{route('movimentacao')}}" class="btn btn-info w-100" title="Movimentações">ENTRADA/SAÍDA</a>    
            </div>
            <div class="col-md-4 mb-3">
              <div class="dropdown">
                <button type="button" class="btn btn-success dropdown-toggle w-100" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Movimentações
                </button>
                <div class="dropdown-menu w-100">
                  <a class="dropdown-item" href="{{route('liberacao.completa')}}">Moradores</a>
                  <a class="dropdown-item" href="{{route('liberacao.completa_visitantes')}}">Visitantes</a>
                  <!--<a class="dropdown-item" href="{{route('lista_ingresso.lista')}}">Listas de Ingresso</a>-->
                </div>
              </div>
            </div>
	    <div class="col-md-4 mb-3">
              <a class="btn btn-outline-secondary w-100" href="{{route('home')}}">
                  <i class="fas fa-home"></i>
                    <span>Inicio</span>
                    <span class="badge badge-pill badge-warning"></span>
              </a>
            </div>
        </div>
    @endif
    <hr>
      <form method="GET" action="{{ route('liberacao.index_saidas') }}">

          <p>Pesquisar por:</p>

            <div class="form-check form-check-inline">
               <input class="form-check-input" type="radio" name="choose_search" value="liberador" id="flexRadioDefault1" {{ request('choose_search', 'liberador') == 'liberador' ? 'checked' : '' }} >
                  <label class="form-check-label" for="flexRadioDefault1">
                      Liberador
                  </label>
            </div>
            <div class="form-check form-check-inline">
               <input class="form-check-input" type="radio" name="choose_search" value="nome_completo" id="flexRadioDefault2" {{ request('choose_search') == 'nome_completo' ? 'checked' : '' }} >
                   <label class="form-check-label" for="flexRadioDefault2">
                         Visitante
                   </label>
            </div>
            <div class="form-check form-check-inline">
               <input class="form-check-input" type="radio" name="choose_search" value="destino" id="flexRadioDefault3" {{ request('choose_search') == 'destino' ? 'checked' : '' }} >
                   <label class="form-check-label" for="flexRadioDefault3">
                         Local
                   </label>
	    </div>

            
           <div class="row">
             <div class="col-md-12 mt-3">
                <div class="form-group input-group">
                   <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
                   <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Digite....">
                   <button type="submit" class="btn-primary btn-sm">Buscar
                      <i class="fa fa-search"></i>
                   </button>
                </div>
             </div>
           </div>
        </form> 
    <hr>
    @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
        <hr>
    @endif

    <div class="row select">
       <!--DAR SA�~MDA-->
        <div class="col-md-12 select">
            <h4>Saída de visitante</h4>
                        <?php $i = 0; ?>
                    <div id="accordion2">
                        @foreach($liberacoes_saidas as $a)
                          <div class="card" id="card_{{$i}}">
                            <div class="card-header" id="headingOne_{{$i}}">
                              <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne_{{$i}}" aria-expanded="true" aria-controls="collapseOne_{{$i}}">
                                    <div class="row">
                                        <i class="fas fa-house-user">{{'  '.$a->destino}}</i>
                                    </div>
                                    <div class="row" style="margin-top: 5px;">
                                        <i class="fas fa-user-check">{{'  '.$a->liberador}}</i>  
                                    </div>
                                    <div class="row" style="margin-top: 5px;">
                                        Visitante: {{'  '.$a->nome_completo.'   '}} Contato: {{' '.$a->contato}}
                                        @php
                                            $dt_hoje = Carbon\Carbon::now()->format('Y-m-d');
                                            $hora = Carbon\Carbon::now()->format('H:i:s');
                                            
                                            $data_ent = $a->dt_entrada.' '.$a->hr_entrada;
                                            $data_saida = $a->dt_saida.' '.$a->hr_saida ;

                                            $dt_e = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data_ent);
                                            $dt_s = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data_saida);

                                        @endphp
                                        @if(\Carbon\Carbon::now()->gt($dt_s))
                                            <i class="fas fa-user-clock" style="color: red;" title="Este visitante já deveria ter saído da vila!"></i>
                                        @endif
                                    </div>
                                    <strong>Ele deve sair até o dia {{date('d/m/Y', strtotime($a->dt_saida))}} as {{$a->hr_saida}}</strong>
                                </button>
                              </h5>
                            </div>

                            <div id="collapseOne_{{$i}}" class="collapse" aria-labelledby="headingOne_{{$i}}" data-parent="#accordion2">
                              <div class="card-body" id="card_body_{{$i}}">
                                @if(($a->movimentacao == 'A'))
                                    <a class="btn btn-success" href="{{route('notificar_entrada', ['onesignal' => $a->onesignal_id, 'id' => $a->id])}}">Entrada</a>
                                @elseif($a->movimentacao == 'E')
                                    <a class="btn btn-danger" href="{{route('notificar_saida', ['onesignal' => $a->onesignal_id, 'id' => $a->id])}}">Saída</a>
                                @elseif($a->movimentacao == 'S')
                                    Movimentação completa:<br>
                                    Entrada: {{date('d-m-Y', strtotime($a->dt_entrou))}} as {{$a->hr_entrou}} <br>
                                    Saída: {{date('d-m-Y', strtotime($a->dt_saiu))}} as {{$a->hr_saiu}}
                                @endif
                              </div>
                            </div>
                          </div>
                        <?php $i++;?>
                        @endforeach
                    </div>
                </div>
        <!--FECHA DAR SA�~MDA--> 

            </div>
            <div class="row justify-content-center align-items-center mt-4">
              <div class="pagination pagination-sm flex-wrap">
                 {{-- Pagination --}}
                 {!! $liberacoes_saidas->appends(['search' => request('search')])->links() !!}
              </div>
            </div>
	</div><!--fim da coluna -->

    </div><!--fim da row -->

</div> <!-- fim do container -->


@endsection

