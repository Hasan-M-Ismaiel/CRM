@props(['users'])

<table class="table table-striped mt-2">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Profile</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Role</th>
            <th scope="col">Tasks</th>
            <th scope="col">Skills</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
            <tr>
                <th scope="row" class="align-middle">{{ $user->id }}</th>
                <!--profile avatar-->
                <td class="align-middle">
                    @if($user->profile)
                        <a href="{{ route('admin.profiles.show', $user->id) }}" style="text-decoration: none;">
                    @else
                        <a href="{{ route('admin.statuses.notFound') }}" style="text-decoration: none;">
                    @endif
                    @if($user->profile && $user->profile->getFirstMediaUrl("profiles"))
                        <img
                        src='{{ $user->profile->getFirstMediaUrl("profiles") }}'
                        alt="DP"  class="  rounded-circle img-fluid  border border-success shadow mb-1" width="35" height="35">
                    @elseif($user->getFirstMediaUrl("users"))
                    <img
                        src='{{ $user->getMedia("users")[0]->getUrl("thumb") }}'
                        alt="DP"  class="  rounded-circle img-fluid border border-success shadow mb-1" width="35" height="35">
                    @else
                    <img
                        src='{{ asset("images/avatar.png") }}'
                        alt="DP"  class="  rounded-circle img-fluid border border-success shadow mb-1" width="35" height="35">
                    @endif
                    </a>
                </td>
                <td class="align-middle"><a href="{{ route('admin.users.show', $user->id) }}" style="text-decoration: none;" >{{ $user->name }} </a></td>
                <td class="align-middle">{{ substr($user->email, 0, 15) }}...</td>
                <td class="align-middle">{{ $user->getRoleNames()->get('0') }}</td>
                <td class="align-middle">{{ $user->numberOfAssignedTasks }}</td>
                <td class="align-middle">
                @if($user->skills()->count() > 0)
                    @foreach ($user->skills as $skill)
                        <span class="badge m-1" style="background: #673AB7;">{{ $skill->name }}</span>
                    @endforeach
                @else
                    #
                @endif
                </td>
                <td class="align-middle">
                    <div style="display: flex;">
                        <a type="button" class="btn btn-primary m-1" href="{{ route('admin.users.show', $user->id) }}" role="button">Show</a>
                        <a type="button" class="btn btn-secondary m-1" href="{{ route('admin.users.edit', $user->id) }}" role="button">Edit</a>
                        <a class="btn btn-danger m-1" type="button"
                                onclick="if (confirm('Are you sure?') == true) {
                                            document.getElementById('delete-item-{{$user->id}}').submit();
                                            event.preventDefault();
                                        } else {
                                            return;
                                        }
                                        ">
                                {{ __('Delete') }}
                        </a>
                        <!-- for the delete  -->
                        <form id="delete-item-{{$user->id}}" action="{{ route('admin.users.destroy', $user) }}" class="d-none" method="POST">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>