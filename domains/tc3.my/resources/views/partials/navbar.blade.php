<nav class="navbar navbar-default" role="navigation">
  <!-- Brand and toggle get grouped for better mobile display -->
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <!--a class="navbar-brand" href="#">Вjobывать!</a-->
    <a class="navbar-brand" href="#">КОЯМ?</a>
  </div>

  <!-- Collect the nav links, forms, and other content for toggling -->
  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    <ul class="nav navbar-nav">
      <li class="active"><a href="#"><b>Today</b>&nbsp;
                    T:&nbsp;<span class="badge" id="today_total">--</span>&nbsp;
                    S/P:&nbsp;<span class="badge" id="today_inv">--</span>
                  </a></li>
                  <li><a href="#about"><b>Week</b> T:&nbsp;<span class="badge" id="week_total">--</span>&nbsp;
                  S/P:&nbsp;<span class="badge" id="week_inv">--</span>
                  </a></li>
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><b>Month O/C:</b> 
          <span class="badge" id="month_0">--</span>
          <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="#" id="month_1">--</a></li>
            <li><a href="#" id="month_2">--</a></li>
            <li><a href="#" id="month_3">--</a></li>
            <li><a href="#" id="month_4">--</a></li>
            <li><a href="#" id="month_5">--</a></li>
            <li><a href="#" id="month_6">--</a></li>
            <li><a href="#" id="month_7">--</a></li>
            <li><a href="#" id="month_8">--</a></li>
            <li><a href="#" id="month_9">--</a></li>
            <li><a href="#" id="month_10">--</a></li>
            <li><a href="#" id="month_11">--</a></li>
            <li><a href="#" id="month_12">--</a></li>
          </ul>
      </li>
    </ul>
    <form class="navbar-form navbar-left" role="search" action="/search" method="post" target="_blank">
      <div class="form-group">
        <!--input type="text" class="form-control" placeholder=""  id="daterange"  size="10" name="date_interval"-->
        <input type="text" class="form-control" placeholder="last days" name="last_days">
        <select class="form-control" placeholder="customer" name="cust" id="cust">
 <option value="3408">Absolut Bank</option><option value="1030">Agropromcredit</option><option value="1069">AKBars</option><option value="1747">ATF Bank</option><option value="239">Atos</option><option value="2">Azericard</option><option value="6568">Aziatsko-Tihookeanskiy Bank</option><option value="6608">Bank Audi</option><option value="754">Bank of Moscow</option><option value="9152">Bank of Valletta</option><option value="230">Belvnesheconombank</option><option value="11311">Borgun</option><option value="6269">BTA Kazan</option><option value="1947">CenterCredit Bank</option><option value="4492">CTM</option><option value="1067">Dalnevostochny Bank</option><option value="12630">EasyCash</option><option value="20696">Ekassir</option><option value="8832">EMIS</option><option value="1071">Equens</option><option value="7748">Equity Bank</option><option value="2828">EurasianBank</option><option value="12650">Finnet</option><option value="16996">Fintrax</option><option value="1051">GorBank_StPetersburg</option><option value="8288">GUTA Bank</option><option value="208">Halyk</option><option value="1068">Hanty-Mansiysky Bank</option><option value="22716">HP</option><option value="9248">ICC</option><option value="4068">Imexbank</option><option value="2267">Industrialbank</option><option value="18096">Infocart</option><option value="515">JUGRA</option><option value="209">Kazkommerts</option><option value="8409">KazSberbank</option><option value="12810">Licard</option><option value="24196">Licard Euroservice</option><option value="19228">LifePay</option><option value="11310">Luottokunta</option><option value="11455">Maritime Bank</option><option value="217">MasterBank</option><option value="215">MDM</option><option value="4549">MEZHTOPENERGOBANK</option><option value="12250">MoldIndconbank</option><option value="3008">Moskommerts</option><option value="10088">MOSOBLBANK</option><option value="2288">MPK</option><option value="14115">National Bank of Oman</option><option value="19656">National Bank of Ukraine</option><option value="1649">National Kredit</option><option value="19976">Network International</option><option value="23656">Non-cash Payment Solutions</option><option value="16136">NovaCard</option><option value="24716">NT-Group</option><option value="1066">NurBank</option><option value="223">Ok (BIN Bank)</option><option value="18216">OpenWay Academy</option><option value="7591">OpenWay Asia</option><option value="1396">OpenWay Belgium</option><option value="8228">OpenWay Cyprus</option><option value="7614">OpenWay Indonesia</option><option value="2007">OpenWay International</option><option value="10871">OpenWay Malaysia</option><option value="5528">OpenWay ME</option><option value="1550">OpenWay Moscow</option><option value="898">OpenWay Service</option><option value="16216">OpenWay Ukraine</option><option value="7600">OpenWay Vietnam</option><option value="2128">ORIENT EXPRESS</option><option value="3068">Oschadniy</option><option value="1440">OTHERS</option><option value="8308">OTKRITIE</option><option value="236">PayNet</option><option value="23136">PaynetEasy</option><option value="222">Petrocommerce</option><option value="8908">PG Bank</option><option value="229">Prior</option><option value="218">Probusiness</option><option value="3388">PROCCO</option><option value="231">Prominvest</option><option value="1906">Promsvyazbank</option><option value="9149">Raiffeisen International</option><option value="16336">RBK Bank</option><option value="1484">Renaissance Capital</option><option value="235">Romcard</option><option value="3228">RosPromBank</option><option value="18617">Rossijskiy Capital</option><option value="9108">Russtroybank</option><option value="17496">SaleServiceSolutions</option><option value="987">SBRF_Russia</option><option value="9848">SBRF_Russia_URAS</option><option value="241">SBRF_Samara</option><option value="240">SBRF_SPb _North-West</option><option value="22697">SCCP</option><option value="7909">SDM-Bank</option><option value="13254">Servius</option><option value="1866">Setib</option><option value="16176">SingleCard</option><option value="13474">Sitronics</option><option value="5548">SMPU</option><option value="3768">Solidarnost</option><option value="11250">TREVICA</option><option value="1">Trust Bank</option><option value="13071">UBS</option><option value="763">UCS</option><option value="11150">UEC</option><option value="12690">UGIS</option><option value="6508">UkrDeltaBank</option><option value="757">UkrEximBank</option><option value="2668">UkrPetrocommerce</option><option value="758">UkrSotsBank</option><option value="8328">UNICRE</option><option value="855">Unicredit Tiriac Bank</option><option value="242">UralSib</option><option value="3069">VBRR</option><option value="1060">VBRR Nefteyugansk</option><option value="760">Victoria</option><option value="9048">Vnesheconombank</option><option value="23437">VnipiSport</option><option value="759">Vozrozhjdeniye</option><option value="213">VTB24</option><option value="3">Zenit</option>
        </select>
        <input type="text" class="form-control" placeholder="any officer" name="owner">
      </div>
      <button type="submit" class="btn btn-default" name="from_form" value="1">Submit</button>
    </form>    


    <div class="btn-group navbar-form">
        <button type="button" class="btn btn-default" id="doHideDone">Hide Completed</button>        
        <button type="button" class="btn btn-default" id="doShowDone">Show Completed</button>
    </div>

    <ul class="nav navbar-nav navbar-right">
      <li><a href="https://infosearcher.cdt.spb.openwaygroup.com/">Search</a></li>
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Исчо <b class="caret"></b></a>
        <ul class="dropdown-menu">
          <li><a href="#">Prj Search</a></li>
          <li><a href="#">Iss Search</a></li>
          <li><a href="#">My recent</a></li>
          <li class="divider"></li>
          <li class="nav-header">Analyze</li>
          <li><a href="#">Proj View</a></li>
          <li><a href="#">Self Planning</a></li>
        </ul>
      </li>
    </ul>
  </div><!-- /.navbar-collapse -->
</nav>