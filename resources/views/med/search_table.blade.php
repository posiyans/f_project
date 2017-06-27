<div class="container well">

   <b>Результат поиска по запросу:</b> <i class="alert-warning">{{ $find }}</i><br>
  @if ($count_woker >  $workers->count())
    показаны {{ $count}} всего {{ $count_woker }} результаты
  @endif
  @if ($workers->count()>0)
  <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Фамилия</th>
                  <th>Имя</th>
                  <th>Отчество</th>
                  <th>Предприятие</th>
                  <th>Должность</th>
                  <th>Дата рождения</th>
                </tr>
              </thead>

              <tbody  class="">
  @foreach ($workers as $i => $worker)
                <tr {!! $worker->data_yvolen ? "class=\"alert alert-danger\"": 'sdsd' !!} >
                  <td>{{ $i+1 }}</td>
                  <td>
                    {{ link_to(route('WorkerView',['id'=>$worker->id]), $worker->fam, ['target' =>'_blank']) }}
                  </td>
                  <td>{{ $worker->name }}</td>
                  <td>{{ $worker->ot }}</td>
                  <td>{{ $worker->firm_id->name }}</td>
                  <td>{{ $worker->dolgn }}</td>
                  <td>{{ Carbon\Carbon::createFromFormat('Y-m-d', $worker->data_rogd)->format('d-m-Y') }}</td>
                </tr>

  @endforeach
              </tbody>
  </table>
 @else
 <br><div class="alert alert-danger">
 По вашему запросу ничего не найдено!!!<br>
 {{Html::link(route('WorkerEdit','new'),'Добавить сотрудника')}}
 </div>



 @endif
</div>