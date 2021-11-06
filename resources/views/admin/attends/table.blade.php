<div class="table-responsive">
    <table class="table" id="attends-table">
        <thead>
            <tr>
                <th>ID</th>
                
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($attends as $attend)
            <tr>
                <td>{{$attend->id}}</td>
                
                <td>
                    {!! Form::open(['route' => ['admin.attends.destroy', $attend->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('admin.attends.show', [$attend->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ route('admin.attends.edit', [$attend->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
