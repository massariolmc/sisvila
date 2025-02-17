@extends('layouts.app')

@section('content')
<div class="container">
   <!-- SELEÇÃO DE TIPO DE USUÁRIO-->
   <div class="container-fluid">
            <div class="custom-container">
                <div class="custom-box">
                    <h5>Parecer da Seção de Inteligência da BACG</h5>
                    <hr>
                         <div class="container justify-content-center">
                            <h5>Nome: {{ $usuarios->name }}</h5>
                            <h5>CPF: {{ $usuarios->cpf }}</h5>
                            <h5>Solicita acesso a: {{ $usuarios->local }}</h5>
                            <hr>
                            <form method="POST" action="{{ route('usuarios.motivo_sint') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="parecer_sint">PARECER</label>
                                            <select class="form-control" id="parecer_sint" name="parecer_sint" required>
                                                    <option value="c">Clique aqui...</option>
                                                    <option style="color: green" value="APROVADO">APROVADO</option>
                                                    <option style="color: red" value="RECUSADO">RECUSADO</option>
                                            </select>
                                        </div> 
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="motivo_sint">Motivo</label>
                                            <textarea class="form-control" id="motivo_sint" rows="3" name="motivo_sint" required></textarea>
                                        </div> 
                                    </div>
                                </div>
                                <input type="hidden" value="{{ $usuarios->id }}" name="id"></input>
                                <div class="row" style="margin-top: 30px;">
                                <div class="col-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">
                                            Enviar
                                        </button>
                                    </div>
                                </div>
                                </div>
                            </form>
                          </div>
                </div>
            </div>
        </div>
@endsection
