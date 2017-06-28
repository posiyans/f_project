<ul class="nav nav-pills col-md-2">
    <li class="active"><a href="#prim" data-toggle="pill">Прим.</a></li>
    <li><a href="#doc" data-toggle="pill">Док. ({{ count($docfiles)}})</a></li>
    <li><a href="#diagnz" data-toggle="pill">Диагнозы ({{ count($diagnos)}})</a></li>
    <li><a href="#sms" data-toggle="pill">SMS</a></li>
    <li><a href="#smshist" data-toggle="pill">SMS история ({{ count($sms)}})</a></li>
    <li><a href="#ref" data-toggle="pill">Справка</a></li>
    @if (count($worker->getParent())>0)
        <li><a href="#parent" data-toggle="pill">Родственники ({{count($worker->getParent())}})</a></li>
    @endif
    <li><a href="#log" data-toggle="pill">История</a></li>

</ul>
<div class="tab-content col-md-10">
    <div class="tab-pane active  well" id="prim">
        <h4>Примечание</h4>
        <p>{{ $worker->prim}}</p>
        <p>{{ $worker->prim_ok}}</p>
    </div>
    <div class="tab-pane  well" id="doc">
        <h4>Докумнты</h4>
            <form action="{{route('WorkerView',$worker->id) }}" enctype="multipart/form-data" method="post">
                <div class="form-group">
                <div class="form-group has-success">
                    <label class="control-label">Добавить файл</label>
                    
                    <input type='text' aria-describedby="" placeholder="Описание файла" name="primdoc" class="form-control" value="">
                    </div>
                    <input id="input-doc" name="filedoc" type="file" class="file" placeholder="Прикрепить файл" data-show-preview="false">
                    {{ csrf_field() }}
                </div>
            </form>
           
        <ul>
        @foreach ($docfiles as $i=>$docfile)
            <li>{{$i+1}}. {{link_to(route('MedFileDownload',$docfile->id),"$docfile->full_name ($docfile->name)")}}</li>


        @endforeach
        </ul>
    </div>
    <div class="tab-pane well" id="diagnz">
        <h4>Диагнозы</h4>
        <ul>
        @foreach ($diagnos as $i=>$item)
            <li>{{$i+1}}. {{$item->mkb->nom_kode}} {{$item->mkb->kode}} <small>{{$item->created_at}}</small></li>


        @endforeach
        </ul>
    </div>
    <div class="tab-pane well " id="sms">
        <p class="{{$smsbalans < 100 ? 'alert-danger': ''}}">Отправка SMS. (баланс: <b>{{ $smsbalans }} </b>руб.)</p>
        
        <div class="form-group has-success">
            <label class="control-label" for="phone">Номер</label>
            <input type='text' aria-describedby="phone" id="phone" class="form-control" value="{{ $smsphone }}"> пример
            <i> 79111234567</i>
        </div>
        <div class="form-group has-success">
            <label class="control-label" for="textsms">Текст SMS</label>
            <textarea class="form-control" rows="7" aria-describedby="textsms" id="textsms"></textarea>
        </div>

            <input type="button" value="Отправить" class="btn btn-primary" onclick="Sendsms({{$worker->id}})">

            <div id="smsres"></div>



    </div>
    <div class="tab-pane well" id="smshist">
        <h4>SMS история</h4>
        @foreach($sms as $i=>$item)
        <p>{{ $i+1}}. {{$item->phone}}<small><ins> {{$item-> created_at }}</ins></small><br>{{$item->text}}<br><b>{{$item->status}}</b></p>

        @endforeach

    </div>
    <div class="tab-pane well" id="ref">
        <h4>Справка</h4>
        <small>
             <b>КМО не оказывается в следующих случаях:</b><br>
            - при заболеваниях туберкулезом, венерических заболеваниях, ВИЧ-инфекции, психических расстройствах и расстройствах поведения, особо опасных инфекциях, наркологических заболеваниях, хронических гепатитах вирусной этиологии, их осложнениях, заболеваниях передающихся половым путем;<br>
            - при травмах и соматических заболеваниях, возникших вследствие  психической патологии;<br>
            - при умышленных телесных повреждениях, попытках  суицида;<br>
            - при профессиональном заболевании: лучевая болезнь;<br>
            - при врожденных аномалиях и пороках развития, генетических заболеваниях и их осложнениях, системных аутоиммунных заболеваниях, системных васкулитах;<br>
            - при онкологических заболеваниях и их осложнениях, новообразованиях центральной нервной системы, нейродегенеративных и демиелинизирующих заболеваниях нервной системы, кондуктивной и нейросенсорной тугоухости и потере слуха;<br>
            - при заболеваниях связанных с  беременностью и их осложнениями;<br>
            - при расстройствах половой функции, нарушении менструального цикла (кроме метроррагии), бесплодии, импотенции, эректильной дисфункции;<br>
            - при всех видах протезирования, ортопедической коррекции, пластической хирургии (кроме операций, проводимых по медицинским показаниям при повреждениях, влекущих за собой нарушение жизненно-важных функций организма) и их осложнениях, реконструктивные операции;<br>
            - при процедурах и операциях, проводимых с эстетической и косметической целью, устранении косметических дефектов (удаление папиллом, бородавок, моллюсков, невусов, мозолей, кондилом, атером, липом, халязион и пр.), склеротерапия вен, диагностике и лечении заболеваний волос (алопеция и др.)<br>
            - при обследовании с целью выдачи справок на право ношения оружия, получении водительского удостоверения, для трудоустройства, для посещения спортивно-оздоровительных мероприятий, для поступления в учебные заведения, для оформления выезда за рубеж, для санаторно-курортных карт.<br>
            <b>4.32.</b>Оказание КМО по исключениям п.4.25. возможно в случае ходатайства  ГД предприятия и по согласованию ПСД

            <table class="table table-bordered">
                <tr>
                    <td></td>
                    <td>Управляющий, Директор, ДС, НО</td>
                    <td>НОС</td>
                    <td>ВС</td><td>специалист, Сотрудник</td>
                </tr>
                <tr>
                    <td>Исп.срок</td><td><b>ЛЮКС</b><br>Амб-поликл.помощь<br>Экстренная + План.госпит.</td>
                    <td>
                        <b>БИЗНЕС</b><br>Амб-поликл.помощь<br>Экстренная +	План.госпит.
                    </td>
                    <td>Амб-поликл.помощь </td>
                    <td>Амб-поликл.помощь </td>
                </tr>
                <tr>
                    <td>1 год</td>
                    <td></td>
                    <td></td>
                    <td><b>БИЗНЕС</b><br>Экстренная +плановая госпитализация </td>
                    <td><b>СТАНДАРТ</b><br>Экстренная госпитализация </td>
                </tr>
            </table>
        </small>
    </div>
    
    @if (count($worker->getParent())>0)
        <div class="tab-pane well" id="parent">
            <h4>Родственники</h4>
            
            @foreach ($worker->getParent() as $parent)
                <p><a href="{{route('WorkerView',$parent->id)}}">{{ $parent->fam}} {{ $parent->name}} {{ $parent->ot }}
                {{$parent->data_rogd}}
                </a></p>
            @endforeach
        </div>
    @endif
    <div class="tab-pane well" id="log">
        <h4>История</h4>
        <p>{!! $worker->history !!}</p>
    </div>
</div>
<!-- tab content -->