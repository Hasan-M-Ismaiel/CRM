@props(['users' ,'project' => null])

<table class="table table-striped mt-2">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Select</th>
            <th scope="col">Name</th>
            <th scope="col">Skills</th>
            <th scope="col">Profile</th>
            <th scope="col">Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
            <tr style="height: 60px;">
                <th scope="row" class="align-middle">{{ $loop->iteration }}</th>
                @if($project != null)
                <td style="text-align: center; vertical-align: middle;"><input type="checkbox" id="user-{{$user->id}}" name="assigned_users[]" value="{{$user->id}}" {{ $user->checkifAssignedToProject($project) ? '' : 'checked' }}></td>
                @else 
                <td style="text-align: center; vertical-align: middle;"><input type="checkbox" id="user-{{$user->id}}" name="assigned_users[]" value="{{$user->id}}"></td>
                @endif
                <td class="align-middle"><a href="{{ route('admin.users.show', $user->id) }}" >{{ $user->name }} </a></td>
                @if($user->skills->count() >0)
                <td class="align-middle">
                    @foreach($user->skills as $skill)
                        <span class="badge bg-dark m-1">{{ $skill->name }}</span>
                    @endforeach
                </td>
                @else
                <td class="align-middle"> # </td>
                @endif
                @if($user->profile != null)
                <td class="align-middle"><a href="{{ route('admin.profiles.show', $user->id) }}" >{{ $user->profile->nickname }} </a></td>
                @else
                <td class="align-middle"> # </td>
                @endif
                <td class="align-middle"> open/close</td>
            </tr>
        @endforeach
    </tbody>
</table>