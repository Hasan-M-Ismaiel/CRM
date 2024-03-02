@extends('layouts.app')

@section('content')
 
<div class="container mb-3">
    <div class="row justify-content-center">
        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="mb-4 mt-4">
                <span class="pt-2 pb-2 pr-3 font-medium text-danger border border-danger border-rounded rounded">
                    <span class="bg-danger py-2 px-2  text-white">Whoops!</span>{{ __(' Something went wrong.') }}
                </span>

                <ul class="mt-3 list-group list-group-flush text-danger">
                    @foreach ($errors->all() as $error)
                        <li class="list-group-item text-danger">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card p-5">
            <div class="container-fluid border my-3  ">
                <div class="row justify-content-center">
                    <div class="card-create-project pt-4 my-3 mx-5 px-5">
                        <h2 id="heading">{{ $page }}</h2>
                        <p id="pcreateProject">dashboard to assign / de-assign project to users </p>
                        <p id="pcreateProject">please add users with skills that match the project skills to avoid removing users in update project later</p>
                        <form action='{{ route("admin.projects.assignStore", $project) }}' method="POST">
                            @csrf
                            @method('PATCH')
                            <table class="table table-striped border mt-2">
                                <thead>
                                    <tr>
                                        <th scope="col" id="pcreateProject">#</th>
                                        <th scope="col" id="pcreateProject">Profile</th>
                                        <th scope="col" id="pcreateProject">Name</th>
                                        <th scope="col" id="pcreateProject">Email</th>
                                        <th scope="col" id="pcreateProject">Role</th>
                                        <th scope="col" id="pcreateProject">profission</th>
                                        <th scope="col" id="pcreateProject">Assign/De-assign</th>
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
                                                        <div class="avatar avatar-md">
                                                            <img src='{{ $user->profile->getFirstMediaUrl("profiles") }}' alt="DP"  class="avatar-img border border-success shadow mb-1">
                                                        </div>
                                                    @elseif($user->getFirstMediaUrl("users"))
                                                    <div class="avatar avatar-md">
                                                        <img src='{{ $user->getMedia("users")[0]->getUrl("thumb") }}' alt="DP"  class="avatar-img border border-success shadow mb-1">
                                                    </div>
                                                    @else
                                                    <div class="avatar avatar-md">
                                                        <img src='{{ asset("images/avatar.png") }}' alt="DP"  class="avatar-img border border-success shadow mb-1">
                                                    </div>
                                                    @endif
                                                </a>
                                            </td>
                                            <td class="align-middle"><a href="{{ route('admin.users.show', $user->id) }}" style="text-decoration: none;" >{{ $user->name }} </a></td>
                                            <td class="align-middle">{{ substr($user->email, 0, 15)  }}...</td>
                                            <td class="align-middle">{{ $user->getRoleNames()->get('0') }}</td>
                                            <td class="align-middle">
                                                @if($user->skills->count()>0)
                                                    @foreach ($user->skills as $skill)
                                                        <span class="badge m-1" style="background: #673AB7;"><a href="{{ route('admin.skills.show', $skill->id) }}" class="text-white" style="text-decoration: none;">{{ $skill->name }}</a></span>
                                                    @endforeach
                                                @else
                                                    #
                                                @endif
                                            </td>
                                            <td class="align-middle">
                                                <input type="checkbox" id="user-{{$user->id}}" name="assigned_users[]" value="{{$user->id}}" {{ $user->checkifAssignedToProject($project) ? '' : 'checked' }}>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <x-forms.assign-button />
                        </form>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</div>
@endsection
