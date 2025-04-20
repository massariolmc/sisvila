@extends('layouts.layout_sem_sidebar')

@section('content')
<div class="container">
    <div class="row align-items-center">
        <div class="col-md-2">
            <img src="/imagens/sisvila2.png" width="80px" height="70px">
        </div>
        <div class="col-md-10">
            <h2>Pesquisa - Moradores/EMEI/Func.Escola</h2>
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
      <form method="GET" action="{{ route('liberacao.index_search_users') }}">

          <p>Pesquisar por:</p>

            <div class="form-check form-check-inline">
               <input class="form-check-input" type="radio" name="choose_search" value="name" id="flexRadioDefault1" {{ request('choose_search', 'name') == 'name' ? 'checked' : '' }} >
                  <label class="form-check-label" for="flexRadioDefault1">
                      Nome
                  </label>
            </div>
            <div class="form-check form-check-inline">
               <input class="form-check-input" type="radio" name="choose_search" value="telefone" id="flexRadioDefault2" {{ request('choose_search') == 'telefone' ? 'checked' : '' }} >
                   <label class="form-check-label" for="flexRadioDefault2">
                         Telefone
                   </label>
            </div>
            <div class="form-check form-check-inline">
               <input class="form-check-input" type="radio" name="choose_search" value="local" id="flexRadioDefault3" {{ request('choose_search') == 'local' ? 'checked' : '' }} >
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

    <div class="row">   

    
    <table class="table table-striped table-bordered display" style="width:100%">
        <thead>
            <tr>
                <!-- <th></th> -->
                <th>Nome Completo</th>
                <th>Telefone</th>
                <th>Local</th>
                <th>Função</th>
                <!-- <th>Status</th>  -->
            </tr>
        </thead>
        <tbody>
            @foreach($usuarios as $l)
                <tr>
                    <!-- <td><input type="checkbox" name="selected[]" value="{{ $l->id }}"></td> -->
                    <td>{{$l->name}}</td>
                    <td>{{$l->telefone}}</td>
                    <td>{{$l->local}}</td>
                    <td>
                        @switch($l->autorizacao)
                                @case('ad')
                                    Administrador
                                    @break
                                @case('mo')
                                    Morador
                                    @break
                                @case('so')
                                    Sócio
                                    @break
                                @case('fe')
                                    Funcionário Escola
                                    @break
                                @case('ef')
                                    Efetivo BACG
                                    @break
                                @case('ra')
                                    Responsável por Aluno
                                    @break
                                @case('al')
                                    Aluno
                                    @break
                                @case('po')
                                    Portaria
                                    @break
                                @default
                                    Desconhecido
                            @endswitch
                    </td>
                    <!-- <td>
                        @if ($l->status == "0")
                            <i class="fas fa-window-close" style="color: red;" title="DESABILITADO NO SISTEMA"></i>
                        @else
                            <i class="fas fa-check-square" style="color: green;" title="HABILITADO NO SISTEMA"></i>
                        @endif
		    </td>
                   -->   
                </tr>
                
            @endforeach
        </tbody>
    </table>
        </div>

        <div class="row justify-content-center align-items-center mt-4">
            <div class="pagination pagination-sm flex-wrap">
              {{-- Pagination --}}
              {!! $usuarios->appends(['search' => request('search')])->links() !!}
           </div>
       </div>
    
</div>

@endsection
