@extends('layouts.layout_sem_sidebar')

@section('style_morador')
body {
    background-color: #e6e6e6; /* Cinza claro */
}
.custom-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}
.custom-box {
    background-color: #ffffff; /* Branco */
    border-radius: 10px; /* Bordas arredondadas */
    padding: 20px;
    box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.3); /* Sombra */
}

.custom-button {
      width: 300px; /* Largura do botão */
      height: 80px; /* Altura do botão */
      display: flex; /* Usando Flexbox */
      flex-direction: column; /* Ícone em cima, texto embaixo */
      align-items: center; /* Centraliza o conteúdo horizontalmente */
      justify-content: center; /* Centraliza o conteúdo verticalmente */
      border: 1px solid #ccc; /* Borda para parecer botão */
      border-radius: 10px; /* Cantos arredondados */
      background-color: #f8f9fa; /* Cor de fundo */
      color: #333; /* Cor do texto */
      text-decoration: none; /* Remove sublinhado */
      transition: background-color 0.2s; /* Animação ao hover */
    }

    .custom-button i {
      font-size: 24px; /* Tamanho do ícone */
      margin-bottom: 5px; /* Espaço entre ícone e texto */
    }

    .custom-button:hover {
      background-color: #e2e6ea; /* Cor ao passar o mouse */
    }

    .button-column {
      display: flex; /* Usando Flexbox */
      flex-direction: column; /* Colocar botões um embaixo do outro */
      gap: 5px; /* Espaço entre botões */
    }

@endsection

@section('content')
<div class="container">
   <!-- SELEÇÃO DE TIPO DE USUÁRIO-->
   <div class="container-fluid">
    <div class="row">
        <div class="col">
            <div class="custom-container">
                <div class="custom-box">
                    <h5>Portaria</h5>
                    <hr>
                         <div class="container mt-5 d-flex justify-content-center">
                            <div class="button-column">

                              <a class="custom-button" href="{{ route('movimentacao') }}" style="background-color: green; color: white;">
                                <i class="fas fa-qrcode"></i>
                                <span>Leitor QRCODE</span>
                              </a>

                              <a class="custom-button" href="{{ route('liberacao.index_entradas') }}" style="background-color: cadetblue;">
                                <i class="fas fa-share"></i>
                                <span>Liberar Entradas</span>
                              </a>

                              <a class="custom-button" href="{{ route('liberacao.index_saidas') }}" style="background-color: burlywood;">
                                <i class="fas fa-reply"></i>
                                <span>Liberar Saidas</span>
                              </a>
			      
                              <a class="custom-button" href="{{ route('liberacao.index_search_users') }}" style="background-color: cadetblue; color: white;">
                                <i class="fas fa-search"></i>
                                <span>Pesquisa - Morador/EMEI/Func.Escola</span>
                              </a>

                              <a class="custom-button" href="{{ route('liberacao.completa') }}" style="background-color: gray; color: white;">
                                <i class="fas fa-user"></i>
                                <span>Movimentacao - Moradores</span>
                              </a>
                              
                              <a class="custom-button" href="{{ route('liberacao.completa_visitantes') }}" style="background-color: cadetblue; color: white;">
                                <i class="fas fa-user-secret"></i>
                                <span>Movimentacao - Visitantes</span>
                              </a>

                              <a class="custom-button" href="{{ route('home') }}" style="background-color: gray; color: white;">
                                <i class="fas fa-home"></i>
                                <span>Inicio</span>
                              </a>

                            </div>
                          </div>
                </div>
            </div>
        </div>
    </div>
</div>  
@endsection
