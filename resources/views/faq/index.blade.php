@extends('partials.main')

@section('content')
			<div class="app-main__outer">
                <div class="app-main__inner">
                <div class="app-page-title">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div class="page-title-icon">
                                    <i class="pe-7s-flag  icon-gradient bg-tempting-azure">
                                    </i>
                                </div>
                                <div>FAQ	
                                </div>
                            </div>
                        </div>
						<br>
                          <div class="card-header-title font-size-sm font-weight-normal" style="float: left;color: grey;">
                         <i class="fas fa-info-circle"></i>
                            <h7> Resposta a todas as suas dúvidas</h7>
                        </div>
                    </div>           
                    <div class="main-card mb-3 card">
                        <div class="card-body"><h5 class="card-title"> FAQ </h5>
                        <style type='text/css'>/*<![CDATA[*/
                                        div.rbtoc1617718721789 {padding: 0px;}
                                        div.rbtoc1617718721789 ul {list-style: disc;margin-left: 0px;}
                                        div.rbtoc1617718721789 li {margin-left: 0px;padding-left: 0px;}

                        /*]]>*/</style><div class='toc-macro rbtoc1617718721789'>
                            <ul class='toc-indentation'>
                            <li><a href='#FAQ-Intelidus360'>Intelidus 360</a>
                            <ul class='toc-indentation'>
                            <li><a href='#FAQ-OqueéaIntelidus360?'>O que é a Intelidus 360?</a></li>
                            <li><a href='#FAQ-ComoacederàIntelidus360?'>Como aceder à Intelidus 360?</a></li>
                            </ul>
                            </li>
                            @if(in_array('2', $modules))
                            <li><a href='#FAQ-Fatura'>Fatura</a>
                            <ul class='toc-indentation'>
                            <li><a href='#FAQ-OqueéumaFatura?'>O que é uma Fatura?</a></li>
                            <li><a href='#FAQ-OqueéumaFaturasimplificada?'>O que é uma Fatura simplificada?</a></li>
                            <li><a href='#FAQ-OqueéumaFaturaRecibo?'>O que é uma Fatura Recibo?</a></li>
                            <li><a href='#FAQ-OqueéumaNotadeCrédito?'>O que é uma Nota de Crédito?</a></li>
                            <li><a href='#FAQ-InformaçãodeFaturas'>Informação de Faturas</a></li>
                            <li><a href='#FAQ-ComocriarumaFatura?'>Como criar uma Fatura?</a></li>
                            <li><a href='#FAQ-ComoapagarumaFatura'>Como apagar uma Fatura</a></li>
                            </ul>
                            </li>
                            <li><a href='#FAQ-Clientes'>Clientes</a>
                            <ul class='toc-indentation'>
                            <li><a href='#FAQ-Comocriarumcliente?'>Como criar um cliente?</a></li>
                            <li><a href='#FAQ-Comoapagarumcliente?'>Como apagar um cliente?</a></li>
                            <li><a href='#FAQ-Comoeditarumcliente?'>Como editar um cliente?</a></li>
                            </ul>
                            </li>
                            <li><a href='#FAQ-Item'>Item</a>
                            <ul class='toc-indentation'>
                            <li><a href='#FAQ-OqueéumItem?'>O que é um Item?</a></li>
                            <li><a href='#FAQ-ComocriarumItem?'>Como criar um Item?</a></li>
                            <li><a href='#FAQ-ComoapagarumItem?'>Como apagar um Item?</a></li>
                            <li><a href='#FAQ-ComoeditarumItem?'>Como editar um Item?</a></li>
                            </ul>
                            </li>
                            @endif
                            @if(in_array('3', $modules))
                            <li><a href='#FAQ-SMS'>SMS</a>
                            <ul class='toc-indentation'>
                            <li><a href='#FAQ-ComomandarumaSMS'>Como mandar uma SMS</a></li>
                            <li><a href='#FAQ-ComovertodasasSMS'>Como ver todas as SMS</a></li>
                            <li><a href='#FAQ-ComovertodososRemetentes'>Como ver todos os Remetentes</a></li>
                            <li><a href='#FAQ-Possocriarumnovoremetente?'>Posso criar um novo remetente?</a></li>
                            </ul>
                            </li>
                            @endif
                            <li><a href='#FAQ-Definições'>Definições</a>
                            <ul class='toc-indentation'>
                            <li><a href='#FAQ-Comoéquevejoosaldodaminhaconta?'>Como é que vejo o saldo da minha conta?</a></li>
                            <li><a href='#FAQ-Comoadicionoaminhainformaçãodecobrança?'>Como adiciono a minha informação de cobrança?</a></li>
                            <li><a href='#FAQ-Comoalteroaminhainformaçãodecobrança?'>Como altero a minha informação de cobrança?</a></li>
                            <li><a href='#FAQ-Comoconsultotodososmovimentosquefiz?'>Como consulto todos os movimentos que fiz?</a></li>
                            <li><a href='#FAQ-Comopossoadicionaraminhaformadepagamento?'>Como posso adicionar a minha forma de pagamento?</a></li>
                            <li><a href='#FAQ-Comoalterarouadicionarummódulo?'>Como alterar ou adicionar um módulo?</a></li>
                            </ul>
                            </li>
                            </ul>
                    </div>
                    <h1 style="text-align: center;" id="FAQ-Intelidus360" >Intelidus 360</h1> <br>
                    <h4 id="FAQ-OqueéaIntelidus360?" style="color:#0080ff">O que é a Intelidus 360?</h4>
                    <p>Intelidus 360 ajuda-o a tratar das suas faturas via normal e via SMS. É uma maneira de automatizar o processo todo de faturação e torná-lo mais facil.</p><br>
                    <h4 id="FAQ-ComoacederàIntelidus360?" style="color:#0080ff" >Como aceder à Intelidus 360?</h4>
                    <p>Se não tem conta em  <a href="https://www.intelidus360.com/" class="external-link" rel="nofollow">https://www.intelidus360.com/</a> pode experimentar grátis, basta apenas criar uma conta e tem acesso à Intelidus 360 se já tem uma conta tem a opção do login.</p>
                    
                    @if(in_array('2', $modules))
                    <h1 style="text-align: center;" id="FAQ-Fatura" >Fatura</h1><br>
                    <h4 id="FAQ-OqueéumaFatura?" style="color:#0080ff">O que é uma Fatura?</h4>
                    <p>Uma fatura é um documento que deve ser emitido sempre que se adquire um bem ou um serviço sujeito a IVA, mesmo que esta não esteja solicitada pelo cliente. </p><br>
                    <h4 id="FAQ-OqueéumaFaturasimplificada?"style="color:#0080ff">O que é uma Fatura simplificada?</h4>
                    <p>Documento emitido apenas para operações em território nacional, sujeito a condições:</p>
                    <p style="margin-left: 30.0px;">Venda de bens por parte dos retalhistas/vendedores ambulantes a um consumidor final, não sujeito passivo de IVA.</p>
                    <p style="margin-left: 30.0px;">O montante total da transação de um bem não pode ser superior a 1.000,00€.</p>
                    <p style="margin-left: 30.0px;">O montante total da prestação de um serviço não pode ser superior a 100,00€</p><br>
                    <h4 id="FAQ-OqueéumaFaturaRecibo?" style="color:#0080ff">O que é uma Fatura Recibo?</h4>
                    <p>Documento que agrega a fatura e o recibo, podendo apenas estar emitida quando a data da fatura e do pagamento coincidem(pronto pagamento).</p>
                    <h4 id="FAQ-OqueéumaNotadeCrédito?" style="color:#0080ff">O que é uma Nota de Crédito?</h4>
                    <p>A nota de crédito é um documento que se emite quando há necessidade de efetuar uma retificação à fatura original. Este documento retificativo a fatura tem como função dar crédito aos clientes.</p><br>
                    <h4 id="FAQ-InformaçãodeFaturas"style="color:#0080ff">Informação de Faturas</h4>
                    <p><strong>Data:</strong>Dia em que a fatura foi criada</p><p><strong>Número da Fatura:</strong> Identificação da fatura no qual os dois primeiros caracteres representam o tipo de fatura e a série é o número interno da empresa.</p>
                    <p><strong>Valor Total: </strong>É o valor total da fatura sem impostos .</p>
                    <p><strong>VAT:</strong> O imposto sobre o valor agregado é um imposto sobre o consumo aplicado a um produto sempre que o valor é agregado em cada etapa da cadeia de abastecimento, desde a produção até o ponto de venda</p>
                    <p><strong>Valor Líquido:</strong> O valor líquido é o montante resultante da soma do valor total com IVA.</p><br>
                    <h4 id="FAQ-Estado"style="color:#0080ff">Estado</h4>
                    <p style="margin-left: 30.0px;"><strong>Rascunho </strong>- É uma fatura incompleta que se posso fazer alterações.</p>
                    <p style="margin-left: 30.0px;"><strong>Pago</strong> - Uma fatura que está paga pelo cliente.</p>
                    <p style="margin-left: 30.0px;"><strong>Final</strong> - Fatura paga pelo cliente e com a assinatura digital.</p>
                    <p style="margin-left: 30.0px;"><strong>Cancelado</strong> - Um fatura que foi cancelada depois de ser paga.</p>
                    <p><strong>SAF T PT :</strong> É um fichieiro de formato XML que facilita a exportação de faturas de maneira a facilitar a recolha de dados das taxas pelos inspetores.</p><br><br> 
                    <h4 id="FAQ-ComocriarumaFatura?"style="color:#0080ff">Como criar uma Fatura?</h4>
                    <h6 id="FAQ-Segueospassosparacriarumafatura:">Segue os passos para criar uma fatura:</h6><ol><li><p>Aceder <strong>Faturação.</strong></p></li><li><p>Em seguida, clique<strong> Documentos</strong> &gt; <strong>Faturas.</strong></p></li><li><p>Nessa página, no canto superior direito tem um botão azul, com diversas opções, para criar uma fatura clica-se na opção “Adicionar Fatura“.</p></li><li><p>Nessa página, é so completar os espaços em branco com a informação pretendida.</p></li><li><p>Para finalizar é so guardar como rascunho ou fatura final.</p></li></ol><br><br>
                    <h4 id="FAQ-ComoapagarumaFatura"style="color:#0080ff">Como apagar uma Fatura</h4>
                    <h6 id="FAQ-SegueospassosparaapagarumaFatura:">Segue os passos para apagar uma Fatura:</h6><ol><li><p>Aceder <strong>Faturação.</strong></p></li><li><p>Em seguida, clique<strong> Documentos</strong> &gt; <strong>Faturas.</strong></p></li><li><p>Nessa página, na tabela dentro do campo <strong>Ações </strong>tem um botão vermelho que elimina a fatura.</p></li></ol><br><br><br>
                    <h1 style="text-align: center;" id="FAQ-Clientes">Clientes</h1><br>
                    <h4 id="FAQ-Comocriarumcliente?"style="color:#0080ff">Como criar um cliente?</h4>
                    <h5 id="FAQ-Segueospassosparacriarumcliente:">Segue os passos para criar um cliente:</h5><ol><li><p>Aceder <strong>Faturação.</strong></p></li><li><p>Em seguida, clique<strong> Clientes.</strong></p></li><li><p>Nessa página, do lado direito tem um botão azul que diz “<strong>Adicionar Cliente</strong>“.</p></li><li><p>Nessa página é só preencher os dados do cliente nos espaços em branco e submeter.</p></li></ol><br><br>
                    <h4 id="FAQ-Comoapagarumcliente?"style="color:#0080ff">Como apagar um cliente?</h4>
                    <h5 id="FAQ-Segueospassosparaapagarumcliente:">Segue os passos para apagar um cliente:</h5><ol><li><p>Aceder<strong> Faturação.</strong></p></li><li><p>Em seguida, clique <strong>Clientes.</strong></p></li><li><p>Na tabela tem 2 botões, sendo que o botão vermelho elimina o cliente.</p></li></ol><br><br>
                    <h4 id="FAQ-Comoeditarumcliente?"style="color:#0080ff">Como editar um cliente?</h4>
                    <h5 id="FAQ-Segueospassosparaeditarumcliente:">Segue os passos para editar um cliente:</h5><ol><li><p>Aceder<strong> Faturação.</strong></p></li><li><p>Em seguida, clique <strong>Clientes.</strong></p></li><li><p>Na tabela tem 2 botões, sendo que o botão amarelo edita o cliente.</p></li><li><p>Em seguida é redirecionado para uma página onde terá que alterar os dados que pretende sobre o cliente.</p></li></ol><br><br><br>
                    
                    <h1 style="text-align: center;" id="FAQ-Item">Item</h1><br>
                    <h4 id="FAQ-OqueéumItem?"style="color:#0080ff">O que é um Item?</h4>
                    <p>Um item é um produto ou serviço que a empresa fornece, que compõe cada linha de fatura.</p><br>
                    <h4 id="FAQ-ComocriarumItem?"style="color:#0080ff">Como criar um Item?</h4>
                    <h5 id="FAQ-Segueospassosparacriarumitem:">Segue os passos para criar um item:</h5><ol><li><p>Aceder <strong>Faturação</strong>.</p></li><li><p>Em seguida, clique em <strong>Itens</strong></p></li><li><p>Nessa página, no lado direito da mesma, tem um botão azul no qual diz “<strong>Adicionar Item</strong>“ basta clicar nesse botão.</p></li><li><p>Nessa página é só preencher todos os espaços em branco e submeter.</p></li></ol><br>
                    <h4 id="FAQ-ComoapagarumItem?"style="color:#0080ff">Como apagar um Item?</h4>
                    <h5 id="FAQ-Segueospassosparaapagarumitem:">Segue os passos para apagar um item:</h5><ol><li><p>Aceder <strong>Faturação</strong>.</p></li><li><p>Em seguida, clique em <strong>Itens</strong></p></li><li><p>Nessa página, na tabela tem dois botões no campo “<strong>Ação</strong>“, o vermelho serve para eliminar o Item.</p></li></ol><br>
                    <h4 id="FAQ-ComoeditarumItem?"style="color:#0080ff">Como editar um Item?</h4>
                    <h5 id="FAQ-Segueospassosparaapagarumitem:.1">Segue os passos para apagar um item:</h5><ol><li><p>Aceder <strong>Faturação</strong>.</p></li><li><p>Em seguida, clique em <strong>Itens</strong></p></li><li><p>Nessa página, na tabela tem dois botões no campo “<strong>Ação</strong>“, o amarelo serve para editar o Item.</p></li><li><p>Ao clicar no botão, irá ser redirecionado para uma página com os dados do Item e é só alterar o Item que deseja alterar.</p></li></ol><br><br><br>
                    @endif
                    @if(in_array('3', $modules))
                    <h1 style="text-align: center;" id="FAQ-SMS">SMS</h1><br>
                    <h4 id="FAQ-ComomandarumaSMS"style="color:#0080ff">Como mandar uma SMS</h4>
                    <h5 id="FAQ-SegueospassosparamandarumaSMS:">Segue os passos para mandar uma SMS:</h5><ol><li><p>Acede <strong>SMS</strong>.</p></li><li><p>Em seguida, clique em <strong>Submeter.</strong></p></li><li><p>Nessa página, é necessário preencher todos os dados e submeter a SMS.</p></li></ol><br>
                    <h4 id="FAQ-ComovertodasasSMS"style="color:#0080ff">Como ver todas as SMS</h4><ol><li><p>Aceder <strong>SMS</strong>.</p></li><li><p>Em seguida, clique em <strong>Lista.</strong></p></li><li><p>Nessa página irá ter uma lista de todas as SMS.</p></li></ol><br>
                    <h4 id="FAQ-ComovertodososRemetentes"style="color:#0080ff">Como ver todos os Remetentes</h4><ol><li><p>Aceder <strong>SMS.</strong></p></li><li><p>Em seguida, clique em <strong>Remetente </strong>&gt;<strong>Lista.</strong></p></li><li><p>Nessa página irá ter uma lista com todos os remetentes criados.</p></li></ol><br>
                    <h4 id="FAQ-Possocriarumnovoremetente?"style="color:#0080ff">Posso criar um novo remetente?</h4>
                    <h5 id="FAQ-Passosparacriarumnovoremetente:">Passos para criar um novo remetente:</h5><ol><li><p>Aceder <strong>SMS.</strong></p></li><li><p>Em seguida, clique em  <strong>Remetente</strong> &gt; <strong>Criar.</strong></p></li><li><p>Nessa página terá que preencher os dados relativos ao remetente.</p></li></ol><br><br><br>
                    @endif
                    <h1 style="text-align: center;" id="FAQ-Definições">Definições</h1><br>
                    <h4 id="FAQ-Comoéquevejoosaldodaminhaconta?"style="color:#0080ff">Como é que vejo o saldo da minha conta?</h4>
                    <h5 id="FAQ-Segueospassosseguintesparaverosaldodasuaconta:">Segue os passos seguintes para ver o saldo da sua conta:</h5><ol><li><p>Aceder <strong>Definições.</strong></p></li><li><p>Em seguida, clique <strong>Definições</strong> &gt; <strong>Conta </strong>&gt; <strong>Saldo da Conta.</strong></p></li><li><p>Nessa página irá ter todas as informações sobre o saldo de conta e como mudar o plano.</p></li></ol><br>
                    <h4 id="FAQ-Comoadicionoaminhainformaçãodecobrança?"style="color:#0080ff">Como adiciono a minha informação de cobrança?</h4>
                    <h5 id="FAQ-Segueospassosseguintesparaadicionarainformaçãodecobrança:">Segue os passos seguintes para adicionar a informação de cobrança:</h5><ol><li><p>Aceder <strong>Definições</strong>.</p></li><li><p>De seguida, clique <strong>Definições</strong> &gt; <strong>Conta</strong> &gt; <strong>Dados de cobrança</strong>.</p></li><li><p>Nessa página é só preencher todos os dados relativos aos seus dados de cobrança.</p></li></ol><br>
                    <h4 id="FAQ-Comoalteroaminhainformaçãodecobrança?"style="color:#0080ff">Como altero a minha informação de cobrança?</h4>
                    <h5 id="FAQ-Segueospassosseguintesparaalterarainformaçãodecobrança:">Segue os passos seguintes para alterar a informação de cobrança:</h5><ol><li><p>Aceder <strong>Definições</strong>.</p></li><li><p>De seguida, clique <strong>Definições</strong> &gt; <strong>Conta</strong> &gt; <strong>Dados de cobrança</strong>.</p></li><li><p>Nessa página tem todos os dados relativos aos seus dados de cobrança para altera-los basta alterar o que se pretende e guardar.</p></li></ol><br>
                    <h4 id="FAQ-Comoconsultotodososmovimentosquefiz?"style="color:#0080ff">Como consulto todos os movimentos que fiz?</h4>
                    <h5 id="FAQ-Passosparavertodososmovimentosrealizados:">Passos para ver todos os movimentos realizados:</h5><ol><li><p>Aceder <strong>Definições</strong>.</p></li><li><p>Em seguida, clique <strong>Definições</strong> &gt; <strong>Conta </strong>&gt; <strong>Lista de Movimentos.</strong></p></li><li><p>Pode verificar todos os seus movimentos e pode escolher a linha temporal dos movimentos.</p></li></ol><br>
                    <h4 id="FAQ-Comopossoadicionaraminhaformadepagamento?"style="color:#0080ff">Como posso adicionar a minha forma de pagamento?</h4>
                    <h5 id="FAQ-Passosparaadicionarumaformadepagamento:">Passos para adicionar uma forma de pagamento:</h5><ol><li><p>Access <strong>Definições.</strong></p></li><li><p>De seguida, clique <strong>Definições</strong> &gt; <strong>Pagamentos.</strong></p></li><li><p>Agora pode escolher entre fazer o pagamento com MBway ou Multibanco e preencher os dados.</p></li></ol><br>
                    <h4 id="FAQ-Comoalterarouadicionarummódulo?"style="color:#0080ff">Como alterar ou adicionar um módulo?</h4>
                    <h5 id="FAQ-Passosseguintesparaadicionaroualterarummódulo:">Passos seguintes para adicionar ou alterar um módulo:</h5><ol><li><p>Aceder <strong>Definições.</strong></p></li><li><p>De seguida, clique <strong>Definições</strong> &gt;<strong> Mudar Módulo</strong>. </p></li><li><p>Agora só tem que escolher qual dos módulos pretende usar.</p></li></ol><p style="margin-left: 30.0px;"></p>
                    </div>

                    
                                                      
                </div>             </div> 

                        
                            
                                
                        </div>
                    </div>
                </div>
            </div>
@endsection
@section('javascript')
<script type="text/javascript">
                function set_default_brand(bid,uid)
        {
            $.confirm({
            title: 'Are You sure!',
            content: 'Are you sure you want to set this as a default Brand ?',
            type: 'orange',
            typeAnimated: true,
            buttons: {
                confirm:{
                    text: 'Yes',
                    btnClass: 'btn-warning',
                    action: function(){
                        
                        set_default_brand_post(bid,uid)
                    }
                },
                close: function () {

                }
            }
        });
        }

function set_default_brand_post(bid,uid){

 	CSRF_TOKEN  = "{{ csrf_token() }}";
    	$.ajax({
                type: "POST",
                url: "{{route('brands.default_brand')}}",
                data: {b_id: bid,u_id:uid, _token: CSRF_TOKEN},
        success: function (data) {
            if(data['success']==="true")
            {
                notif({
                        msg: "<b>Success : </b>Brand with id = "+data['id']+" set as default Successfully",
                        type: "success"
                    });
            }
            else if(data['success']==="false")
            {
                notif({
                    msg: "<b>Error!</b> Brand with id = "+data['id']+" does not exist",
                    type: "error",
                    position: "center"
                });
            }
	},
    error:function(err){
		notif({
				type: "warning",
				msg: "<b>Warning:</b> Something Went Wrong",
				position: "left"
			});
    }
  });
}
</script>
@endsection