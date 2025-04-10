@extends('layouts.layout_sem_sidebar')

@section('content')
<div class="container">
    <div class="row align-items-center">
        <div class="col-md-2">
            <img src="/imagens/sisvila2.png" width="80px" height="70px">        
        </div>
        <div class="col-md-10">
            <h2>Entradas de Visitantes Cadastrados</h2>
        </div>
    </div>
    
    <hr>
    @if (in_array('ad', $userProfiles) || in_array('po', $userProfiles))
        <div class="row">
            <div class="col-md-6 mb-3">
                <a href="{{route('movimentacao')}}" class="btn btn-info w-100" title="Movimentacao">Leitor QRCODE</a>    
            </div>
	    <div class="col-md-6 mb-3">
              <a class="btn btn-outline-secondary w-100" href="{{route('liberacao.index')}}">
                  <i class="fas fa-building"></i>
                    <span>Portaria</span>
                    <span class="badge badge-pill badge-warning"></span>
              </a>
            </div>
        </div>
    @endif
    <hr>
      <form method="GET" action="{{ route('liberacao.index_entradas') }}">

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
        <div class="col-md-12">
            <h4>Liberações para Entrada</h4>
                <?php $i = 0; ?>
            <div id="accordion">
                @foreach($liberacoes_entradas as $a)
                @php
                                            $dt_hoje = Carbon\Carbon::now()->format('Y-m-d');
                                            $hora = Carbon\Carbon::now()->format('H:i:s');
                                            
                                            $data_ent = $a->dt_entrada.' '.$a->hr_entrada;
                                            $data_saida = $a->dt_saida.' '.$a->hr_saida ;

                                            $dt_e = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data_ent);
                                            $dt_s = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data_saida);

                                            $check = \Carbon\Carbon::now()->between($dt_e, $dt_s);
                @endphp
                @if($check)
                  <div class="card" id="card_{{$i}}">
                    <div class="card-header" id="headingOne_{{$i}}">
                      <h5 class="mb-0">
                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne_{{$i}}" aria-expanded="true" aria-controls="collapseOne_{{$i}}">
                            <div class="row">
                                @if($a->movimentacao == 'E')
                                    <label style="color: red;">Este visitante já entrou!</label>
                                @elseif($a->movimentacao == 'A')
                                    @if($a->status == 'Liberado')                                
                                    @else
                                        <label style="background-color: red; color: white;">VISITANTE BLOQUEADO</label>
                                    @endif    
                                    @if($a->dt_entrada < \Carbon\Carbon::now()->format('Y-m-d') || $a->dt_saida < \Carbon\Carbon::now()->format('Y-m-d'))
                                        <i class="fas fa-exclamation-triangle" style="color: darkred;" title="INVALIDAR ESTA LIBERAÇÃO"></i>
                                    @endif
                                @else
                                    <label style="color: green;">Movimentação completa</label>
                                @endif
                            </div>
                            <div class="row">
                                <i class="fas fa-house-user">{{'  '.$a->destino}}</i>
                            </div>
                            <div class="row" style="margin-top: 5px;">
                                <i class="fas fa-user-check">{{'  '.$a->liberador}}</i>  
                            </div>
                            <div class="row" style="margin-top: 5px;">
                                Visitante: {{'  '.$a->apelido}} ( {{$a->nome_completo}} ) - Contato: {{' '.$a->contato}}
                            </div>
                            @if(!is_null($a->observacao))
                            <div class="row" style="margin-top: 5px; color: red;">
                                Observação: {{'  '.$a->observacao}}
                            </div>
                            @endif
                        </button>
                      </h5>
                    </div>

                    <div id="collapseOne_{{$i}}" class="collapse" aria-labelledby="headingOne_{{$i}}" data-parent="#accordion">
                      <div class="card-body" id="card_body_{{$i}}">
                                        @if($check)
                                            <a class="btn btn-success" href="{{route('notificar_entrada', ['onesignal' => $a->onesignal_id, 'id' => $a->id])}}">Entrada</a>
                                        @else
                                             <i class="fas fa-user-clock" style="color: red;"></i>Este visitante não pode entrar na vila! O período liberado foi: <strong>{{date('d/m/Y', strtotime($a->dt_entrada))}} às {{$a->hr_entrada}} até o dia {{date('d/m/Y', strtotime($a->dt_saida))}} às {{$a->hr_saida}}</strong>
                                             @if($dt_e < \Carbon\Carbon::now() || $dt_s < \Carbon\Carbon::now())
                                                <br><a class="btn btn-warning" href="{{route('invalidar_entrada', ['onesignal' => $a->onesignal_id, 'id' => $a->id])}}">INVALIDAR LIBERAÇÃO!</a>
                                             @endif
                                        @endif
                      </div>
                    </div>
                  </div>
                @endif   
                <?php $i++;?>
                @endforeach

            </div>
            <div class="row justify-content-center align-items-center mt-4">
              <div class="pagination pagination-sm flex-wrap">
                 {{-- Pagination --}}
                 {!! $liberacoes_entradas->appends(['search' => request('search')])->links() !!}
              </div>
            </div>
	</div><!--fim da coluna -->

    </div><!--fim da row -->

</div> <!-- fim do container -->


@endsection

