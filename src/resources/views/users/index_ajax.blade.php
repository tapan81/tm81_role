@php $count=0 @endphp
@forelse($users as $user)
@php ($count++)
<tr>
    <td>{{$count}}</td>
    <td><input type="checkbox" id="checkbox{{ $user->id }}" name="ids[]" class="checkbox" value="{{ $user->id }}"></td>
    <td>{{ $user->name }}</td>
    <td>{{ $user->email }}</td>
    
    <td>
        <a href="{{ route('users.show', $user->id) }}" class="btn btn-info fa fa-eye"> View</a>
    	<a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary fa fa-edit"> Edit</a>
        <form action="{{ route('users.destroy', $user->id) }}" method="POST"
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
    <td colspan="6" style="text-align:center">No Records Found.</td>
</tr>
@endforelse
<tr>
    <td colspan="4" style="text-align:left;padding-top: 47px;">
    Showing {{($users->currentpage()-1)*$users->perpage()+1}} to {{$users->currentpage()*$users->perpage()}}
    of  {{$users->total()}} entries
    </td>
    <td colspan="2" style="text-align:left;padding-top: 22px;">{{ $users->links() }} <!--Pagignation--></td>
</tr>
