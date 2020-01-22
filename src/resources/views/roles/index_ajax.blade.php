@php $count=0 @endphp
@forelse($roles as $role)
@php ($count++)
<tr>
    <td>{{$count}}</td>
    <td><input type="checkbox" id="checkbox{{ $role->id }}" name="ids[]" class="checkbox" value="{{ $role->id }}"></td>
    <td>{{ $role->name }}</td>
    <td>{{ $role->display_name  }}</td>
    
    <td>
        <a href="{{ route('roles.show', $role->id) }}" class="btn btn-info fa fa-eye"> View</a>
        <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-primary fa fa-edit"> Edit</a>
        <form action="{{ route('roles.destroy', $role->id) }}" method="POST"
              style="display: inline"
              onsubmit="return confirm('Are you sure?');">
            <input type="hidden" name="_method" value="DELETE">
            {{ csrf_field() }}
            <button class="btn btn-danger fa fa-trash-o"> Delete</button>
        </form>
        
    </td>
</tr>
@empty
<tr>
    <td colspan="5" style="text-align:center">No Records Found.</td>
</tr>
@endforelse
<tr>
    <td colspan="3" style="text-align:left;padding-top: 47px;">
    Showing {{($roles->currentpage()-1)*$roles->perpage()+1}} to {{$roles->currentpage()*$roles->perpage()}}
    of  {{$roles->total()}} entries
    </td>
    <td colspan="2" style="text-align:left;padding-top: 22px;">{{ $roles->links() }} <!--Pagignation--></td>
</tr>
