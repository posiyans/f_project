            
                <H3>{{ $worker->fam}} {{ $worker->name}} {{ $worker->ot }}  {{ $worker->data_rogd }}
        
                <a href="{{route('WorkerEdit',$worker->id)}}">{{Html::image('src/img/b_edit.png')}}</a>
                @if ($worker->data_yvolen)
                  <span class="alert-danger">Уволен  {{$worker->data_yvolen}}</span>
                @endif

                </h3> 
                <table class="table table-bordered table-striped {!!$worker->data_yvolen ? 'alert-danger':''!!}">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>#</th>
                      <th>#</th>
                    </tr>
                </thead>

                  <tbody>
                    <tr>
                      <td>Предприятие</td>
                      <td>
                        @if (isset($worker->firm_id->name))
                            {{ $worker->firm_id->name }}
                        @endif
                      </td>
                      <td>
                        @if (isset($worker->firm_1c_id->name))
                            {{ $worker->firm_1c_id->name }}
                        @endif
                      </td>
                    </tr>
                    <tr  class="ps">
                      <td class="ps">Должность</td>
                      <td>{{ $worker->dolgn }}</td>
                      <td>{{ $worker->dolgn_1c }}</td>
                    </tr>
                    <tr>
                      <td>Статус</td>
                      <td>
                        @if (isset($worker->status))
                            {{ $worker->status->full_name }}
                        @endif
                      
                      </td>
                      <td>
                        @if (isset($worker->status_1c))
                            {{ $worker->status_1c->full_name }}
                        @endif
                     
                      </td>
                    </tr>
                    <tr>
                      <td>Принят на работу</td>
                      <td>
                        @if (isset($worker->data_prinyat))
                            {{ Carbon\Carbon::createFromFormat('Y-m-d', $worker->data_prinyat)->format('d-m-Y') }}</td>
                        @endif
                      <td>
                        @if (isset($worker->data_prinyat_1c))
                            {{ Carbon\Carbon::createFromFormat('Y-m-d', $worker->data_prinyat_1c)->format('d-m-Y') }}
                        @endif
                      </td>
                    </tr>
                    <tr>
                      <td>Телефон</td>
                      <td>{{ $worker->phone }}</td>
                      <td>{{ $worker->phone_1c }}</td>
                    </tr>
                    <tr>
                      <td>Адрес проживания</td>
                      <td>
                        @if (isset($worker->adress))
                            {{ link_to('https://www.google.ru/maps/place/'.$worker->adress, $worker->adress, ['target' =>'_blank'] ) }}
                        @endif
                      </td>
                      <td>
                        @if (isset($worker->adress_1c))
                            {{ link_to('https://www.google.ru/maps/place/'.$worker->adress_1c, $worker->adress_1c, ['target' =>'_blank'] ) }}
                        @endif
                      </td>
                    </tr>
                    <tr>
                      <td>Адрес прописки</td>
                      <td>
                        @if (isset($worker->adress_propiski))
                            {{ link_to('https://www.google.ru/maps/place/'.$worker->adress_propiski, $worker->adress_propiski, ['target' =>'_blank'] ) }}
                        @endif
                      </td>
                      <td>
                        @if (isset($worker->adress_propiski_1c))
                            {{ link_to('https://www.google.ru/maps/place/'.$worker->adress_propiski_1c, $worker->adress_propiski_1c, ['target' =>'_blank'] ) }}
                        @endif
                      </td>
                    </tr>
                    <tr>
                      <td>Поликлиника </td>
                      <td>{{ $worker->poliklinika }}</td>
                      <td>{{ $worker->poliklinika_1c }}</td>
                    </tr>
                   
                    <tr onclick="showMany()">
                      <td></td>
                      <td><b>ДМС</b> в этом году {{$money->dms_now }} руб. ( Всего {{$money->dms_all }} руб.)<span class="caret"></span></td>
                      <td><b>ОМС</b>  в этом году {{$money->oms_now}} руб. (Всего {{$money->oms_all }} руб.)<span class="caret"></span></td>
                    </tr>
                    <tr class="maney" style="display: none;" >
                      <td>
                        Плановая госпитализация
                      </td>
                      <td>
                        {{$money->m3_now}} руб. ({{$money->m3_all}} руб.)
                      </td>
                      <td>
                        {{$money->m7_now}} руб. ({{$money->m7_all}} руб.)
                      </td>
                    </tr>
                    <tr class="maney" style="display: none;" >
                      <td>
                        Амбулаторная помощь
                      </td>
                      <td>
                        {{$money->m4_now}} руб. ({{$money->m4_all}} руб.)
                      </td>
                      <td>
                        {{$money->m8_now}} руб. ({{$money->m8_all}} руб.)
                      </td>
                    </tr>
                    <tr class="maney" style="display: none;" >
                      <td>
                        Экстренная госпитализация
                      </td>
                      <td>
                        {{$money->m5_now}} руб. ({{$money->m5_all}} руб.)
                      </td>
                      <td>
                        {{$money->m9_now}} руб. ({{$money->m9_all}} руб.)
                      </td>
                    </tr>
                    <tr class="maney" style="display: none;" >
                      <td>
                        Скорая помощь
                      </td>
                      <td>
                      {{$money->m6_now}} руб. ({{$money->m6_all}} руб.)
                      </td>
                      <td>
                      {{$money->m10_now}} руб. ({{$money->m10_all}} руб.)
                      </td>
                    </tr>
                  </tbody>
                </table>

